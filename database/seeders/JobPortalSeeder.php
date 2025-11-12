<?php

namespace Database\Seeders;

use App\Models\JobPortal;
use Illuminate\Database\Seeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JobPortalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $portalValue = [
            [
                'title' => 'JobStreet Philippines',
                'description' => 'One of the most popular job portals in the Philippines, connecting employers and job seekers across all industries, including hospitality and IT.',
                'link' => 'https://www.jobstreet.com.ph',
                'status' => 'Active'
            ],
            [
                'title' => 'Indeed',
                'description' => 'A global job search engine where you can find job openings from companies worldwide, including both local and remote positions.',
                'link' => 'https://www.indeed.com',
                'status' => 'Active'
            ],
            [
                'title' => 'LinkedIn Jobs',
                'description' => 'A professional networking platform that also functions as a job portal, ideal for building connections and applying for positions directly.',
                'link' => 'https://www.linkedin.com/jobs',
                'status' => 'Active'
            ],
            [
                'title' => 'Kalibrr',
                'description' => 'A modern job platform widely used in the Philippines, known for its clean interface and career matching features for students and graduates.',
                'link' => 'https://www.kalibrr.com',
                'status' => 'Active'
            ],
            [
                'title' => 'PhilJobNet',
                'description' => 'The official job portal of the Philippine Department of Labor and Employment (DOLE), offering both local and overseas job opportunities.',
                'link' => 'https://philjobnet.gov.ph',
                'status' => 'Active'
            ],
            [
                'title' => 'OnlineJobs.ph',
                'description' => 'A popular platform for Filipino freelancers to find remote and work-from-home opportunities from international employers.',
                'link' => 'https://www.onlinejobs.ph',
                'status' => 'Active'
            ],
            [
                'title' => 'Foundit Philippines',
                'description' => 'Formerly Monster Philippines, Foundit is a job portal that connects applicants to companies across Asia, including the Philippines.',
                'link' => 'https://www.foundit.com.ph',
                'status' => 'Active'
            ],
            [
                'title' => 'Dice',
                'description' => 'A U.S.-based job portal that focuses on tech and IT jobs, making it ideal for BSIT and BSCS graduates looking for specialized opportunities.',
                'link' => 'https://www.dice.com',
                'status' => 'Active'
            ],
            [
                'title' => 'Wellfound (AngelList)',
                'description' => 'A startup-focused job portal where you can find opportunities in tech startups and innovative companies around the world.',
                'link' => 'https://www.wellfound.com',
                'status' => 'Active'
            ],
            [
                'title' => 'Fiverr',
                'description' => 'A freelance marketplace where you can offer services or find short-term projects, perfect for freelancers or students building their experience.',
                'link' => 'https://www.fiverr.com',
                'status' => 'Active'
            ],
        ];

        foreach ($portalValue as $item) {
            JobPortal::create($item);
        }
    }
}
