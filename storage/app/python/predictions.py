# -*- coding: utf-8 -*-
import sys
import pandas as pd
import numpy as np
import mysql.connector
from mysql.connector import Error
import warnings
import pickle
import os
from sklearn.linear_model import LinearRegression
from sklearn.preprocessing import StandardScaler
from sklearn.ensemble import RandomForestClassifier
from sklearn.model_selection import train_test_split, cross_val_score
from sklearn.metrics import classification_report, confusion_matrix

# Fix encoding issues on Windows
if sys.platform == 'win32':
    import codecs
    if sys.stdout.encoding != 'utf-8':
        sys.stdout.reconfigure(encoding='utf-8')
    if sys.stderr.encoding != 'utf-8':
        sys.stderr.reconfigure(encoding='utf-8')

# Suppress warnings
warnings.filterwarnings("ignore")

# MySQL Configuration
DB_CONFIG = {
    'host': 'localhost',
    'user': 'root',
    'password': '',
    'database': 'pathfinder'
}

# Model file paths
MODEL_FILE = 'rf_model.pkl'
SCALER_FILE = 'scaler.pkl'
LR_MODEL_FILE = 'lr_model.pkl'

def get_db_connection():
    """Create MySQL database connection"""
    try:
        connection = mysql.connector.connect(**DB_CONFIG)
        if connection.is_connected():
            print("[OK] Successfully connected to MySQL database")
            return connection
    except Error as e:
        print(f"[ERROR] Error connecting to MySQL: {e}")
        return None

def load_training_data(connection):
    """Load training dataset from 'dataset' table"""
    try:
        query = """
        SELECT 
            age,
            employability,
            openness_ave,
            conscientiousness_ave,
            extraversion_ave,
            agreeableness_ave,
            neuroticism_ave,
            soft_skill_ave,
            CPGA,
            OJT,
            member_of_organization,
            leadership_experience,
            work_experience,
            freelance,
            hard_skill_ave
        FROM dataset
        WHERE employability IS NOT NULL
        AND employability != ''
        """
        
        df = pd.read_sql(query, connection)
        df = df.rename(columns={'CPGA': 'cgpa', 'OJT': 'ojt'})
        
        print(f"[OK] Loaded {len(df)} training records from 'dataset' table")
        
        # Show class distribution
        if len(df) > 0:
            employable = len(df[df['employability'] == 'Employable'])
            not_employable = len(df[df['employability'] == 'Not Employable'])
            print(f"  - Employable: {employable} ({employable/len(df)*100:.1f}%)")
            print(f"  - Not Employable: {not_employable} ({not_employable/len(df)*100:.1f}%)")
            
            # Warn if dataset is imbalanced
            if employable < len(df) * 0.3 or employable > len(df) * 0.7:
                print(f"  [WARNING] Dataset is imbalanced! Consider balancing for better predictions.")
        
        if len(df) == 0:
            print("[ERROR] No training data found! Please add alumni data to 'dataset' table.")
            return None
            
        return df
        
    except Error as e:
        print(f"[ERROR] Error loading training data: {e}")
        import traceback
        traceback.print_exc()
        return None

def load_prediction_data(connection, id=None):
    """Load students who completed assessment and need predictions"""
    try:
        if id:
            query = f"""
            SELECT 
                id,
                student_id,
                sex,
                age,
                civil_status,
                program,
                CPGA,
                OJT,
                soft_skill_ave,
                hard_skill_ave,
                openness_ave,
                conscientiousness_ave,
                extraversion_ave,
                agreeableness_ave,
                neuroticism_ave,
                member_of_organization,
                leadership_experience,
                work_experience,
                freelance
            FROM users
            WHERE id = {id}
            AND is_assessment_completed = 1
            """
        else:
            query = """
            SELECT 
                id,
                student_id,
                sex,
                age,
                civil_status,
                program,
                CPGA,
                OJT,
                soft_skill_ave,
                hard_skill_ave,
                openness_ave,
                conscientiousness_ave,
                extraversion_ave,
                agreeableness_ave,
                neuroticism_ave,
                member_of_organization,
                leadership_experience,
                work_experience,
                freelance
            FROM users
            WHERE is_assessment_completed = 1
            """
        
        df = pd.read_sql(query, connection)
        df = df.rename(columns={'CPGA': 'cgpa', 'OJT': 'ojt'})
        
        print(f"[OK] Loaded {len(df)} students for prediction from 'users' table")
        
        if len(df) > 0:
            print(f"\n  Sample data for first student:")
            print(f"  ID: {df.iloc[0]['id']}")
            print(f"  Student ID: {df.iloc[0]['student_id']}")
            print(f"  Sex: {df.iloc[0]['sex']}")
            print(f"  Age: {df.iloc[0]['age']}")
            print(f"  Civil Status: {df.iloc[0]['civil_status']}")
            print(f"  Program: {df.iloc[0]['program']}")
            print(f"  CGPA: {df.iloc[0]['cgpa']}")
            print(f"  OJT: {df.iloc[0]['ojt']}")
            print(f"  Soft Skills Average: {df.iloc[0]['soft_skill_ave']}")
            print(f"  Hard Skills Average: {df.iloc[0]['hard_skill_ave']}")
            print(f"  Openness Average: {df.iloc[0]['openness_ave']}")
            print(f"  Conscientiousness Average: {df.iloc[0]['conscientiousness_ave']}")
            print(f"  Extraversion Average: {df.iloc[0]['extraversion_ave']}")
            print(f"  Agreeableness Average: {df.iloc[0]['agreeableness_ave']}")
            print(f"  Neuroticism Average: {df.iloc[0]['neuroticism_ave']}")
            print(f"  Member of Organization: {df.iloc[0]['member_of_organization']}")
            print(f"  Leadership Experience: {df.iloc[0]['leadership_experience']}")
            print(f"  Work Experience: {df.iloc[0]['work_experience']}")
            print(f"  Freelance: {df.iloc[0]['freelance']}")

        return df
        
    except Error as e:
        print(f"[ERROR] Error loading prediction data: {e}")
        import traceback
        traceback.print_exc()
        return None

def save_predictions_to_db(connection, predictions_df):
    """Save predictions directly to users table"""
    try:
        cursor = connection.cursor()
        
        print(f"\n  Available columns in results: {predictions_df.columns.tolist()}")
        print(f"  Number of records to save: {len(predictions_df)}")
        
        update_query = """
        UPDATE users 
        SET employability = %s,
            employability_probability = %s,
            predicted_employment_rate = %s,
            predicted_date = CURDATE()
        WHERE id = %s
        """
        
        updated_count = 0
        failed_count = 0
        
        for idx, row in predictions_df.iterrows():
            try:
                user_id = int(row['id'])
                employability = str(row['predicted_employability'])
                probability = float(row['employability_probability'])
                employment_rate = float(row['predicted_employment_rate'])
                
                values = (employability, probability, employment_rate, user_id)
                
                print(f"\n  Updating User ID {user_id}:")
                print(f"    Employability: {employability}")
                print(f"    Probability: {probability}%")
                print(f"    Employment Rate: {employment_rate}%")
                
                cursor.execute(update_query, values)
                
                if cursor.rowcount > 0:
                    updated_count += 1
                    print(f"    [OK] Successfully updated")
                else:
                    failed_count += 1
                    print(f"    [ERROR] No rows updated (user might not exist)")
                    
            except Exception as e:
                failed_count += 1
                print(f"    [ERROR] Error: {e}")
        
        connection.commit()
        
        print(f"\n[OK] Commit successful!")
        print(f"  Successfully updated: {updated_count} records")
        if failed_count > 0:
            print(f"  Failed: {failed_count} records")
        
        cursor.close()
        return True
        
    except Error as e:
        print(f"[ERROR] Error saving predictions: {e}")
        print(f"  Error details: {str(e)}")
        import traceback
        traceback.print_exc()
        connection.rollback()
        return False

def save_model_metrics(connection, train_accuracy, test_accuracy, overfitting_gap):
    """Save model performance metrics to model table"""
    try:
        cursor = connection.cursor()
        
        insert_query = """
        INSERT INTO model (
            training_accuracy, 
            testing_accuracy, 
            overfitting_gap,
            created_at,
            updated_at
        ) VALUES (%s, %s, %s, NOW(), NOW())
        """
        
        values = (
            round(train_accuracy * 100, 2),
            round(test_accuracy * 100, 2),
            round(overfitting_gap * 100, 2)
        )
        
        cursor.execute(insert_query, values)
        connection.commit()
        
        print(f"\n[OK] Model metrics saved successfully")
        print(f"  Training Accuracy: {values[0]}%")
        print(f"  Testing Accuracy: {values[1]}%")
        print(f"  Overfitting Gap: {values[2]}%")
        
        cursor.close()
        return True
        
    except Error as e:
        print(f"[ERROR] Error saving model metrics: {e}")
        import traceback
        traceback.print_exc()
        return False

def save_predictions_to_placeholder(connection, predict_df, results_df):
    """Save or update predictions in dataset_placeholder table"""
    try:
        cursor = connection.cursor()
        
        # Check if record exists query
        check_query = """
        SELECT COUNT(*) FROM dataset_placeholder WHERE student_id = %s
        """
        
        # Insert query
        insert_query = """
        INSERT INTO dataset_placeholder (
            student_id,
            age,
            sex,
            civil_status,
            program,
            employability,
            openness_ave,
            conscientiousness_ave,
            extraversion_ave,
            agreeableness_ave,
            neuroticism_ave,
            soft_skill_ave,
            hard_skill_ave,
            CPGA,
            OJT,
            member_of_organization,
            leadership_experience,
            work_experience,
            freelance
        ) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
        """
        
        # Update query
        update_query = """
        UPDATE dataset_placeholder SET
            age = %s,
            sex = %s,
            civil_status = %s,
            program = %s,
            employability = %s,
            openness_ave = %s,
            conscientiousness_ave = %s,
            extraversion_ave = %s,
            agreeableness_ave = %s,
            neuroticism_ave = %s,
            soft_skill_ave = %s,
            hard_skill_ave = %s,
            CPGA = %s,
            OJT = %s,
            member_of_organization = %s,
            leadership_experience = %s,
            work_experience = %s,
            freelance = %s
        WHERE student_id = %s
        """
        
        saved_count = 0
        updated_count = 0
        failed_count = 0
        
        for idx, row in predict_df.iterrows():
            try:
                prediction = results_df[results_df['id'] == row['id']].iloc[0]
                
                student_id = str(row['student_id'])
                
                # Check if student already exists
                cursor.execute(check_query, (student_id,))
                exists = cursor.fetchone()[0] > 0
                
                # Prepare values (without student_id for update)
                data_values = (
                    int(row['age']) if pd.notna(row['age']) else None,
                    str(row['sex']) if pd.notna(row['sex']) else None,
                    str(row['civil_status']) if pd.notna(row['civil_status']) else None,
                    str(row['program']) if pd.notna(row['program']) else None,
                    str(prediction['predicted_employability']),
                    float(row['openness_ave']) if pd.notna(row['openness_ave']) else None,
                    float(row['conscientiousness_ave']) if pd.notna(row['conscientiousness_ave']) else None,
                    float(row['extraversion_ave']) if pd.notna(row['extraversion_ave']) else None,
                    float(row['agreeableness_ave']) if pd.notna(row['agreeableness_ave']) else None,
                    float(row['neuroticism_ave']) if pd.notna(row['neuroticism_ave']) else None,
                    float(row['soft_skill_ave']) if pd.notna(row['soft_skill_ave']) else None,
                    float(row['hard_skill_ave']) if pd.notna(row['hard_skill_ave']) else None,
                    float(row['cgpa']) if pd.notna(row['cgpa']) else None,
                    bool(row['ojt']) if pd.notna(row['ojt']) else False,
                    bool(row['member_of_organization']) if pd.notna(row['member_of_organization']) else False,
                    bool(row['leadership_experience']) if pd.notna(row['leadership_experience']) else False,
                    bool(row['work_experience']) if pd.notna(row['work_experience']) else False,
                    bool(row['freelance']) if pd.notna(row['freelance']) else False
                )
                
                if exists:
                    # Update existing record
                    cursor.execute(update_query, data_values + (student_id,))
                    updated_count += 1
                    print(f"  [UPDATE] Updated existing record for Student ID {student_id}")
                else:
                    # Insert new record
                    insert_values = (student_id,) + data_values
                    cursor.execute(insert_query, insert_values)
                    saved_count += 1
                    print(f"  [NEW] Created new record for Student ID {student_id}")
                    
            except Exception as e:
                failed_count += 1
                print(f"  [ERROR] Error saving Student ID {row['student_id']}: {e}")
        
        connection.commit()
        
        print(f"\n[OK] Dataset placeholder commit successful!")
        print(f"  New records created: {saved_count}")
        print(f"  Existing records updated: {updated_count}")
        if failed_count > 0:
            print(f"  Failed: {failed_count} records")
        
        cursor.close()
        return True
        
    except Error as e:
        print(f"[ERROR] Error saving to dataset_placeholder: {e}")
        print(f"  Error details: {str(e)}")
        import traceback
        traceback.print_exc()
        connection.rollback()
        return False

def train_model(train_df, connection):
    """Train Random Forest model and save it to disk"""
    
    print("\n=== Training Random Forest Model (Anti-Overfitting Settings) ===")
    
    feature_columns = [
        'age', 
        'cgpa', 
        'ojt',
        'soft_skill_ave', 
        'hard_skill_ave',
        'openness_ave',
        'conscientiousness_ave',
        'extraversion_ave',
        'agreeableness_ave',
        'neuroticism_ave',
        'member_of_organization',
        'leadership_experience',
        'work_experience',
        'freelance'
    ]
    
    for col in feature_columns:
        train_df[col] = pd.to_numeric(train_df[col], errors='coerce')
    
    X = train_df[feature_columns].copy()
    y = train_df['employability']
    
    X = X.fillna(X.mean())
    
    lr_model = LinearRegression()
    y_binary = y.map({'Employable': 1, 'Not Employable': 0})
    y_binary = y_binary.fillna(0)
    
    lr_model.fit(X, y_binary)
    train_df['employment_rate'] = lr_model.predict(X) * 100
    
    X_train, X_test, y_train, y_test = train_test_split(
        X, y, test_size=0.2, random_state=42, stratify=y
    )
    
    scaler = StandardScaler()
    X_train_scaled = scaler.fit_transform(X_train)
    X_test_scaled = scaler.transform(X_test)
    
    rf_model = RandomForestClassifier(
        n_estimators=50,
        max_depth=8,
        min_samples_split=20,
        min_samples_leaf=10,
        max_features='sqrt',
        random_state=42,
        class_weight='balanced',
        max_leaf_nodes=30,
        min_impurity_decrease=0.01
    )
    rf_model.fit(X_train_scaled, y_train)
    
    train_score = rf_model.score(X_train_scaled, y_train)
    test_score = rf_model.score(X_test_scaled, y_test)
    overfitting_gap = train_score - test_score
    
    print(f"  Training Accuracy: {train_score:.2%}")
    print(f"  Testing Accuracy: {test_score:.2%}")
    print(f"  Gap (Overfitting Indicator): {overfitting_gap:.2%}")
    
    save_model_metrics(connection, train_score, test_score, overfitting_gap)
    
    print("\n=== Cross-Validation Results ===")
    cv_scores = cross_val_score(rf_model, X_train_scaled, y_train, cv=5, scoring='accuracy')
    print(f"  CV Scores: {[f'{score:.2%}' for score in cv_scores]}")
    print(f"  Mean CV Accuracy: {cv_scores.mean():.2%} (+/- {cv_scores.std() * 2:.2%})")
    
    y_pred = rf_model.predict(X_test_scaled)
    print("\n=== Model Performance Details ===")
    print(classification_report(y_test, y_pred, target_names=['Not Employable', 'Employable']))
    
    print("\n=== Confusion Matrix ===")
    cm = confusion_matrix(y_test, y_pred, labels=['Not Employable', 'Employable'])
    print(f"                    Predicted")
    print(f"                Not Emp  Employable")
    print(f"Actual Not Emp    {cm[0][0]:4d}     {cm[0][1]:4d}")
    print(f"       Employable {cm[1][0]:4d}     {cm[1][1]:4d}")
    
    feature_importance = pd.DataFrame({
        'Feature': X.columns,
        'Importance': rf_model.feature_importances_
    }).sort_values('Importance', ascending=False)
    
    print("\n=== Feature Importance (ALL Features) ===")
    for idx, row in feature_importance.iterrows():
        print(f"  {row['Feature']}: {row['Importance']:.4f}")
    
    print("\n=== Saving Models to Disk ===")
    try:
        with open(MODEL_FILE, 'wb') as f:
            pickle.dump(rf_model, f)
        print(f"  [OK] Saved Random Forest model to {MODEL_FILE}")
        
        with open(SCALER_FILE, 'wb') as f:
            pickle.dump(scaler, f)
        print(f"  [OK] Saved scaler to {SCALER_FILE}")
        
        with open(LR_MODEL_FILE, 'wb') as f:
            pickle.dump((lr_model, train_df[['age', 'cgpa', 'employment_rate']]), f)
        print(f"  [OK] Saved Linear Regression model to {LR_MODEL_FILE}")
        
    except Exception as e:
        print(f"  [ERROR] Error saving models: {e}")
        return False
    
    return True

def predict_students(predict_df, connection):
    """Load trained model and make predictions"""
    
    print("\n=== Loading Trained Models ===")
    
    if not os.path.exists(MODEL_FILE) or not os.path.exists(SCALER_FILE) or not os.path.exists(LR_MODEL_FILE):
        print("[ERROR] Model files not found! Please train the model first using: python script.py train")
        return None
    
    try:
        with open(MODEL_FILE, 'rb') as f:
            rf_model = pickle.load(f)
        print(f"  [OK] Loaded Random Forest model from {MODEL_FILE}")
        
        with open(SCALER_FILE, 'rb') as f:
            scaler = pickle.load(f)
        print(f"  [OK] Loaded scaler from {SCALER_FILE}")
        
        with open(LR_MODEL_FILE, 'rb') as f:
            lr_model, train_data = pickle.load(f)
        print(f"  [OK] Loaded Linear Regression model from {LR_MODEL_FILE}")
        
    except Exception as e:
        print(f"  [ERROR] Error loading models: {e}")
        return None
    
    print("\n=== Making Predictions ===")
    
    feature_columns = [
        'age', 
        'cgpa', 
        'ojt',
        'soft_skill_ave', 
        'hard_skill_ave',
        'openness_ave',
        'conscientiousness_ave',
        'extraversion_ave',
        'agreeableness_ave',
        'neuroticism_ave',
        'member_of_organization',
        'leadership_experience',
        'work_experience',
        'freelance'
    ]
    
    for col in feature_columns:
        predict_df[col] = pd.to_numeric(predict_df[col], errors='coerce')
    
    X_predict = predict_df[feature_columns].copy()
    X_predict = X_predict.fillna(X_predict.mean())
    
    X_predict_scaled = scaler.transform(X_predict)
    predictions = rf_model.predict(X_predict_scaled)
    probabilities = rf_model.predict_proba(X_predict_scaled)
    
    class_labels = rf_model.classes_
    employable_idx = np.where(class_labels == 'Employable')[0][0]
    
    results_df = predict_df[['id', 'student_id']].copy()
    results_df['predicted_employability'] = predictions
    results_df['employability_probability'] = (probabilities[:, employable_idx] * 100).round(2)
    
    def calculate_employment_rate(row, train_data):
        try:
            age_val = float(row['age'])
            cgpa_val = float(row['cgpa'])
            
            similar = train_data[
                (train_data['age'].between(age_val-2, age_val+2)) &
                (train_data['cgpa'].between(cgpa_val-0.5, cgpa_val+0.5))
            ]
            if len(similar) > 0:
                return similar['employment_rate'].mean()
            return train_data['employment_rate'].mean()
        except:
            return train_data['employment_rate'].mean()
    
    results_df['age'] = predict_df['age']
    results_df['cgpa'] = predict_df['cgpa']
    
    results_df['predicted_employment_rate'] = results_df.apply(
        lambda row: calculate_employment_rate(row, train_data), axis=1
    ).round(2)
    
    print("\n=== Prediction Results ===")
    for _, row in results_df.iterrows():
        print(f"\nID: {row['id']} | Student ID: {row['student_id']}")
        print(f"  Prediction: {row['predicted_employability']}")
        print(f"  Probability: {row['employability_probability']}%")
        print(f"  Employment Rate: {row['predicted_employment_rate']}%")
    
    return results_df

def main():
    """Main execution function"""
    print("\n" + "="*60)
    print("  STUDENT EMPLOYABILITY PREDICTION SYSTEM")
    print("="*60 + "\n")
    
    if len(sys.argv) < 2:
        print("Usage:")
        print("  python script.py train              - Train the model")
        print("  python script.py predict            - Predict all students")
        print("  python script.py predict <user_id>  - Predict specific student")
        sys.exit(1)
    
    mode = sys.argv[1].lower()
    
    if mode not in ['train', 'predict']:
        print("[ERROR] Invalid mode! Use 'train' or 'predict'")
        sys.exit(1)
    
    try:
        print("=== Database Connection ===")
        connection = get_db_connection()
        if not connection:
            print("\n[ERROR] Failed to connect to database. Please check your credentials.")
            sys.exit(1)
        
        if mode == 'train':
            print("\n-> MODE: Training Model\n")
            
            print("=== Loading Training Data ===")
            train_df = load_training_data(connection)
            
            if train_df is None or len(train_df) == 0:
                print("\n[ERROR] Cannot proceed without training data.")
                print("  Please add alumni data with employability to 'dataset' table.")
                connection.close()
                sys.exit(1)
            
            if len(train_df) < 100:
                print(f"\n[WARNING] Only {len(train_df)} training records found.")
                print("  Recommend at least 1000+ records for reliable predictions.")
            
            success = train_model(train_df, connection)
            
            if success:
                print("\n" + "="*60)
                print("  MODEL TRAINING COMPLETED SUCCESSFULLY!")
                print("  You can now use: python script.py predict")
                print("="*60 + "\n")
            else:
                print("\n[ERROR] Model training failed.")
                sys.exit(1)
        
        elif mode == 'predict':
            print("\n-> MODE: Predicting Students\n")
            
            user_id = None
            if len(sys.argv) > 2:
                user_id = int(sys.argv[2])
                print(f"-> Predicting for user ID: {user_id}\n")
            else:
                print("-> Predicting for all students with completed assessments\n")
            
            print("=== Loading Students for Prediction ===")
            predict_df = load_prediction_data(connection, user_id)
            
            if predict_df is None:
                print("\n[ERROR] Error loading student data.")
                connection.close()
                sys.exit(1)
            
            if len(predict_df) == 0:
                print("\n[ERROR] No students found that need predictions.")
                print("  Students must have:")
                print("    - is_assessment_completed = 1 (TRUE)")
                print("\n  Check with SQL:")
                print("    SELECT id, student_id, is_assessment_completed FROM users;")
                connection.close()
                sys.exit(0)
            
            results_df = predict_students(predict_df, connection)
            
            if results_df is None:
                print("\n[ERROR] Prediction failed.")
                connection.close()
                sys.exit(1)
            
            print("\n=== Saving Predictions to Users Table ===")
            success = save_predictions_to_db(connection, results_df)
            
            if not success:
                print("\n[ERROR] Failed to save predictions. Check the error messages above.")
            else:
                print("\n=== Verifying Saved Data ===")
                verify_query = """
                SELECT id, student_id, employability, employability_probability, 
                       predicted_employment_rate, predicted_date
                FROM users 
                WHERE is_assessment_completed = 1
                """
                verify_df = pd.read_sql(verify_query, connection)
                print(verify_df.to_string(index=False))
            
            print("\n=== Saving to Dataset Placeholder ===")
            placeholder_success = save_predictions_to_placeholder(connection, predict_df, results_df)
            
            if not placeholder_success:
                print("\n[ERROR] Failed to save to dataset_placeholder.")
            
            employable_count = sum(results_df['predicted_employability'] == 'Employable')
            not_employable_count = sum(results_df['predicted_employability'] == 'Not Employable')
            avg_prob = results_df['employability_probability'].mean()
            avg_emp_rate = results_df['predicted_employment_rate'].mean()
            
            print("\n=== Summary ===")
            print(f"  Total Students Predicted: {len(results_df)}")
            print(f"  Employable: {employable_count} ({employable_count/len(results_df)*100:.1f}%)")
            print(f"  Not Employable: {not_employable_count} ({not_employable_count/len(results_df)*100:.1f}%)")
            print(f"  Average Probability: {avg_prob:.2f}%")
            print(f"  Average Employment Rate: {avg_emp_rate:.2f}%")
            
            print("\n" + "="*60)
            print("  PREDICTION COMPLETED SUCCESSFULLY!")
            print("="*60 + "\n")
        
        connection.close()
        
    except Exception as e:
        print(f"\n[ERROR] Error in main execution: {e}")
        import traceback
        traceback.print_exc()
        sys.exit(1)

if __name__ == "__main__":
    main()