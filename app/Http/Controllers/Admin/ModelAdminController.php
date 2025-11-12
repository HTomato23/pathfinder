<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ModelAdminController extends Controller
{
    public function index()
    {
        // Fetch the latest model metrics
        $latestMetrics = DB::table('model')
            ->latest('created_at')
            ->first();

        // Count records in dataset_placeholder
        $readyToSyncCount = DB::table('dataset_placeholder')->count();

        return response()
            ->view('admin.dashboard.model.index', [
                'trainingAccuracy' => $latestMetrics->training_accuracy ?? 0,
                'testingAccuracy' => $latestMetrics->testing_accuracy ?? 0,
                'overfittingGap' => $latestMetrics->overfitting_gap ?? 0,
                'readyToSyncCount' => $readyToSyncCount,
            ])
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function syncDataset()
    {
        try {
            DB::beginTransaction();

            // Get all records from dataset_placeholder
            $placeholderRecords = DB::table('dataset_placeholder')->get();

            if ($placeholderRecords->isEmpty()) {
                return redirect()->back()->with('error', 'No records to sync. Dataset placeholder is empty.');
            }

            $syncedCount = 0;
            $skippedCount = 0;

            // Insert each record into dataset table
            foreach ($placeholderRecords as $record) {
                // Check if student_id already exists in dataset
                $exists = DB::table('dataset')
                    ->where('student_id', $record->student_id)
                    ->exists();

                if ($exists) {
                    // Update existing record instead of inserting
                    DB::table('dataset')
                        ->where('student_id', $record->student_id)
                        ->update([
                            'age' => $record->age,
                            'sex' => $record->sex,
                            'civil_status' => $record->civil_status,
                            'program' => $record->program,
                            'employability' => $record->employability,
                            'openness_ave' => $record->openness_ave,
                            'conscientiousness_ave' => $record->conscientiousness_ave,
                            'extraversion_ave' => $record->extraversion_ave,
                            'agreeableness_ave' => $record->agreeableness_ave,
                            'neuroticism_ave' => $record->neuroticism_ave,
                            'soft_skill_ave' => $record->soft_skill_ave,
                            'hard_skill_ave' => $record->hard_skill_ave,
                            'CPGA' => $record->CPGA,
                            'OJT' => $record->OJT,
                            'member_of_organization' => $record->member_of_organization,
                            'leadership_experience' => $record->leadership_experience,
                            'work_experience' => $record->work_experience,
                            'freelance' => $record->freelance,
                        ]);
                    $skippedCount++;
                } else {
                    // Insert new record
                    DB::table('dataset')->insert([
                        'student_id' => $record->student_id,
                        'age' => $record->age,
                        'sex' => $record->sex,
                        'civil_status' => $record->civil_status,
                        'program' => $record->program,
                        'employability' => $record->employability,
                        'openness_ave' => $record->openness_ave,
                        'conscientiousness_ave' => $record->conscientiousness_ave,
                        'extraversion_ave' => $record->extraversion_ave,
                        'agreeableness_ave' => $record->agreeableness_ave,
                        'neuroticism_ave' => $record->neuroticism_ave,
                        'soft_skill_ave' => $record->soft_skill_ave,
                        'hard_skill_ave' => $record->hard_skill_ave,
                        'CPGA' => $record->CPGA,
                        'OJT' => $record->OJT,
                        'member_of_organization' => $record->member_of_organization,
                        'leadership_experience' => $record->leadership_experience,
                        'work_experience' => $record->work_experience,
                        'freelance' => $record->freelance,
                    ]);
                    $syncedCount++;
                }
            }

            // Use delete() instead of truncate() - truncate() commits the transaction!
            DB::table('dataset_placeholder')->delete();

            DB::commit();

            // Build success message for sync
            $message = "Successfully synced to dataset table: {$syncedCount} new records added";
            if ($skippedCount > 0) {
                $message .= ", {$skippedCount} records updated";
            }

            // Now train the model automatically
            $trainingResult = $this->trainModelAfterSync();

            if ($trainingResult['success']) {
                $message .= ". " . $trainingResult['message'];
                return redirect()->back()->with('success', $message);
            } else {
                $message .= ". However, model training failed: " . $trainingResult['message'];
                return redirect()->back()->with('warning', $message);
            }

            // Log activity
            ActivityLog::create([
                'admin_admin_id' => Auth::guard('admin')->id(),
                'action' => 'Trained',
                'description' => "Trained the model",
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Sync failed: ' . $e->getMessage());
        }
    }

    private function trainModelAfterSync()
    {
        try {
            // Check if dataset has enough records
            $datasetCount = DB::table('dataset')->count();

            if ($datasetCount < 50) {
                return [
                    'success' => false,
                    'message' => "Insufficient training data. Found {$datasetCount} records. Need at least 50 records."
                ];
            }

            // Run Python training script
            $pythonDir = base_path('storage/app/python');
            $scriptName = 'predictions.py';

            // Windows command with UTF-8 encoding
            $command = "chcp 65001 > nul && cd /d {$pythonDir} && python {$scriptName} train 2>&1";

            $output = [];
            $returnVar = 0;

            Log::info('Starting automatic model training after sync');

            exec($command, $output, $returnVar);

            $outputText = implode("\n", $output);

            if ($returnVar === 0) {
                Log::info('Model training completed successfully', [
                    'output' => $outputText
                ]);

                // Get the latest metrics from database
                $latestMetrics = DB::table('model')
                    ->latest('created_at')
                    ->first();

                $successMessage = "Model trained successfully!";
                if ($latestMetrics) {
                    $successMessage .= " Training Accuracy: {$latestMetrics->training_accuracy}%, Testing Accuracy: {$latestMetrics->testing_accuracy}%";
                }

                return [
                    'success' => true,
                    'message' => $successMessage
                ];
            } else {
                Log::error('Model training failed', [
                    'error' => $outputText
                ]);

                return [
                    'success' => false,
                    'message' => 'Check logs for details'
                ];
            }
        } catch (\Exception $e) {
            Log::error('Exception during model training', [
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
