<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\CounsellorAttendance;
use App\Models\CounsellorAvailability;
use App\Models\CounsellorProfile;
use App\Models\DiscountCoupon;
use App\Models\Payment;
use App\Models\TrainingProgramme;
use App\Models\TrainingRegistration;
use App\Models\User;
use App\Support\Roles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PrafultaDemoSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@prafulta.local'],
            [
                'name' => 'Admin User',
                'phone' => '9990000001',
                'password' => Hash::make('password'),
                'role' => Roles::ADMIN,
                'email_verified_at' => now(),
            ]
        );

        $trainingManager = User::query()->updateOrCreate(
            ['email' => 'training@prafulta.local'],
            [
                'name' => 'Training Manager',
                'phone' => '9990000002',
                'password' => Hash::make('password'),
                'role' => Roles::TRAINING_MANAGER,
                'email_verified_at' => now(),
            ]
        );

        $counsellors = [
            User::query()->updateOrCreate(
                ['email' => 'counsellor@prafulta.local'],
                [
                    'name' => 'Counsellor One',
                    'phone' => '9990000003',
                    'password' => Hash::make('password'),
                    'role' => Roles::COUNSELLOR,
                    'email_verified_at' => now(),
                ]
            ),
            User::query()->updateOrCreate(
                ['email' => 'counsellor2@prafulta.local'],
                [
                    'name' => 'Counsellor Two',
                    'phone' => '9990000013',
                    'password' => Hash::make('password'),
                    'role' => Roles::COUNSELLOR,
                    'email_verified_at' => now(),
                ]
            ),
        ];

        $clients = [
            User::query()->updateOrCreate(
                ['email' => 'client@prafulta.local'],
                [
                    'name' => 'Client User',
                    'phone' => '9990000004',
                    'password' => Hash::make('password'),
                    'role' => Roles::CLIENT,
                    'email_verified_at' => now(),
                ]
            ),
            User::query()->updateOrCreate(
                ['email' => 'client2@prafulta.local'],
                [
                    'name' => 'Client User Two',
                    'phone' => '9990000005',
                    'password' => Hash::make('password'),
                    'role' => Roles::CLIENT,
                    'email_verified_at' => now(),
                ]
            ),
            User::query()->updateOrCreate(
                ['email' => 'client3@prafulta.local'],
                [
                    'name' => 'Client User Three',
                    'phone' => '9990000006',
                    'password' => Hash::make('password'),
                    'role' => Roles::CLIENT,
                    'email_verified_at' => now(),
                ]
            ),
        ];

        $profiles = [
            [
                'user_id' => $counsellors[0]->id,
                'bio' => 'Child and adolescent counselling specialist.',
                'specializations' => ['Child behaviour', 'Parent guidance'],
                'session_modes' => ['video', 'call', 'in_person'],
                'session_duration_minutes' => 60,
                'session_price' => 1500,
                'is_active' => true,
            ],
            [
                'user_id' => $counsellors[1]->id,
                'bio' => 'Occupational and remedial therapy support specialist.',
                'specializations' => ['Occupational therapy', 'Remedial support'],
                'session_modes' => ['in_person', 'video'],
                'session_duration_minutes' => 45,
                'session_price' => 1800,
                'is_active' => true,
            ],
        ];

        foreach ($profiles as $profile) {
            CounsellorProfile::query()->updateOrCreate(
                ['user_id' => $profile['user_id']],
                $profile
            );
        }

        foreach ($counsellors as $index => $counsellor) {
            for ($i = 0; $i < 8; $i++) {
                CounsellorAvailability::query()->updateOrCreate(
                    [
                        'counsellor_id' => $counsellor->id,
                        'available_date' => today()->addDays($i)->toDateString(),
                        'start_time' => '10:00:00',
                        'end_time' => '14:00:00',
                    ],
                    [
                        'is_available' => true,
                        'source' => $index === 0 ? 'self' : 'admin',
                        'reason' => null,
                    ]
                );
            }
        }

        $bookings = [
            [
                'booking_reference' => 'BK-000001',
                'client_id' => $clients[0]->id,
                'counsellor_id' => $counsellors[0]->id,
                'service_type' => 'regular_counselling',
                'session_mode' => 'video',
                'scheduled_at' => now()->subDays(4),
                'status' => 'completed',
                'payment_status' => 'paid',
                'amount' => 1500,
                'discount_amount' => 0,
                'is_offline_booking' => false,
                'created_by' => $clients[0]->id,
            ],
            [
                'booking_reference' => 'BK-000002',
                'client_id' => $clients[1]->id,
                'counsellor_id' => $counsellors[0]->id,
                'service_type' => 'regular_counselling',
                'session_mode' => 'in_person',
                'scheduled_at' => now()->addDays(2),
                'status' => 'confirmed',
                'payment_status' => 'paid',
                'amount' => 1500,
                'discount_amount' => 150,
                'is_offline_booking' => false,
                'created_by' => $clients[1]->id,
            ],
            [
                'booking_reference' => 'BK-000003',
                'client_id' => $clients[2]->id,
                'counsellor_id' => $counsellors[1]->id,
                'service_type' => 'occupational_therapy',
                'session_mode' => 'in_person',
                'scheduled_at' => now()->addDays(1),
                'status' => 'pending',
                'payment_status' => 'pending',
                'amount' => 1800,
                'discount_amount' => 0,
                'is_offline_booking' => true,
                'created_by' => $admin->id,
            ],
            [
                'booking_reference' => 'BK-000004',
                'client_id' => $clients[0]->id,
                'counsellor_id' => $counsellors[1]->id,
                'service_type' => 'remedial_therapy',
                'session_mode' => 'in_person',
                'scheduled_at' => now()->subDays(1),
                'status' => 'cancelled',
                'payment_status' => 'refunded',
                'amount' => 1800,
                'discount_amount' => 0,
                'is_offline_booking' => true,
                'created_by' => $admin->id,
            ],
        ];

        foreach ($bookings as $bookingData) {
            $booking = Booking::query()->updateOrCreate(
                ['booking_reference' => $bookingData['booking_reference']],
                $bookingData
            );

            $paymentPurpose = $bookingData['status'] === 'cancelled' ? 'refund' : 'booking';
            $paymentStatus = $bookingData['payment_status'] === 'refunded' ? 'refunded' : ($bookingData['payment_status'] === 'paid' ? 'paid' : 'pending');

            Payment::query()->updateOrCreate(
                ['booking_id' => $booking->id, 'payment_purpose' => $paymentPurpose],
                [
                    'training_registration_id' => null,
                    'method' => $bookingData['is_offline_booking'] ? 'cash' : 'razorpay',
                    'status' => $paymentStatus,
                    'amount' => $bookingData['amount'] - $bookingData['discount_amount'],
                    'transaction_reference' => 'TXN-'.$bookingData['booking_reference'],
                    'receipt_number' => 'RCPT-'.$bookingData['booking_reference'],
                    'meta' => ['seeded' => true],
                ]
            );

            if ($bookingData['status'] === 'completed') {
                DB::table('session_notes')->updateOrInsert(
                    ['booking_id' => $booking->id, 'counsellor_id' => $booking->counsellor_id],
                    [
                        'notes' => 'Session completed successfully. Follow-up suggested after one week.',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }

            if ($bookingData['status'] === 'cancelled') {
                DB::table('cancellation_requests')->updateOrInsert(
                    ['booking_id' => $booking->id],
                    [
                        'requested_by' => $booking->client_id,
                        'reason' => 'Unable to attend due to travel schedule.',
                        'status' => 'approved',
                        'reviewed_by' => $admin->id,
                        'reviewed_at' => now()->subHours(6),
                        'created_at' => now()->subDay(),
                        'updated_at' => now(),
                    ]
                );
            }
        }

        DiscountCoupon::query()->updateOrCreate(
            ['code' => 'WELCOME10'],
            [
                'discount_type' => 'percentage',
                'value' => 10,
                'service_type' => 'regular_counselling',
                'usage_limit' => 100,
                'used_count' => 6,
                'expires_at' => now()->addMonths(2),
                'is_active' => true,
            ]
        );

        DiscountCoupon::query()->updateOrCreate(
            ['code' => 'PRAFULTA500'],
            [
                'discount_type' => 'fixed',
                'value' => 500,
                'service_type' => 'training',
                'usage_limit' => 50,
                'used_count' => 9,
                'expires_at' => now()->addMonths(1),
                'is_active' => true,
            ]
        );

        foreach ($counsellors as $counsellor) {
            CounsellorAttendance::query()->updateOrCreate(
                [
                    'counsellor_id' => $counsellor->id,
                    'attendance_date' => today()->toDateString(),
                ],
                [
                    'status' => 'present',
                    'note' => 'Available for scheduled sessions.',
                ]
            );
        }

        $programmeA = TrainingProgramme::query()->updateOrCreate(
            ['title' => 'Parents Behaviour Support Programme'],
            [
                'category' => 'Parents',
                'description' => 'Structured year-wise modules for parent support and intervention techniques.',
                'location' => 'Prafulta Center',
                'start_date' => now()->addMonth()->toDateString(),
                'end_date' => now()->addMonths(3)->toDateString(),
                'modules' => ['Module 1', 'Module 2', 'Module 3'],
                'registration_fee' => 2500,
                'balance_fee' => 7500,
                'is_active' => true,
            ]
        );

        $programmeB = TrainingProgramme::query()->updateOrCreate(
            ['title' => 'Teachers Inclusive Classroom Programme'],
            [
                'category' => 'Teachers',
                'description' => 'Hands-on training for inclusive strategies and behavioural support in classrooms.',
                'location' => 'Online + Mumbai Center',
                'start_date' => now()->addWeeks(3)->toDateString(),
                'end_date' => now()->addMonths(2)->toDateString(),
                'modules' => ['Foundations', 'Classroom Tools', 'Assessments'],
                'registration_fee' => 3000,
                'balance_fee' => 9000,
                'is_active' => true,
            ]
        );

        // ── Additional training programmes for content-rich listing ──
        $additionalProgrammes = [
            [
                'title' => 'Emotion Regulation for Adolescents',
                'category' => 'Parents',
                'description' => 'Learn evidence-based strategies to help your teen manage emotions, handle stress, and build resilience during challenging transitions.',
                'location' => 'Online',
                'start_date' => now()->addWeeks(2)->toDateString(),
                'end_date' => now()->addMonths(2)->toDateString(),
                'modules' => ['Understanding Emotions', 'CBT Basics for Parents', 'Communication Techniques', 'Crisis Navigation'],
                'registration_fee' => 1800,
                'balance_fee' => 5400,
                'is_active' => true,
            ],
            [
                'title' => 'Sensory Integration Awareness',
                'category' => 'Teachers',
                'description' => 'Understand sensory processing challenges and build classroom environments that support children with sensory needs.',
                'location' => 'Prafulta Center',
                'start_date' => now()->addWeeks(4)->toDateString(),
                'end_date' => now()->addMonths(3)->toDateString(),
                'modules' => ['Sensory Basics', 'Classroom Adaptations', 'Assessment Tools', 'Intervention Planning', 'Case Studies'],
                'registration_fee' => 3500,
                'balance_fee' => 10500,
                'is_active' => true,
            ],
            [
                'title' => 'Autism Spectrum: Early Intervention Guide',
                'category' => 'Professionals',
                'description' => 'A structured programme for therapists and educators covering early detection, assessment, and intervention strategies for ASD.',
                'location' => 'Mumbai Center',
                'start_date' => now()->addMonth()->toDateString(),
                'end_date' => now()->addMonths(4)->toDateString(),
                'modules' => ['ASD Overview', 'Screening Tools', 'ABA Fundamentals', 'Social Skills Teaching', 'Family Support', 'Progress Tracking'],
                'registration_fee' => 4000,
                'balance_fee' => 12000,
                'is_active' => true,
            ],
            [
                'title' => 'Mindfulness in the Classroom',
                'category' => 'Teachers',
                'description' => 'Integrate mindfulness and calm-down techniques into daily classroom routines to improve focus, self-regulation, and group dynamics.',
                'location' => 'Online + Pune Center',
                'start_date' => now()->addWeeks(5)->toDateString(),
                'end_date' => now()->addMonths(2)->toDateString(),
                'modules' => ['Mindfulness Theory', 'Breathing Exercises', 'Movement Activities', 'Teacher Self-Care'],
                'registration_fee' => 2000,
                'balance_fee' => 6000,
                'is_active' => true,
            ],
            [
                'title' => 'Positive Discipline Workshop',
                'category' => 'Parents',
                'description' => 'Move from punishment to connection. Learn positive discipline tools that encourage cooperation and build long-term skills.',
                'location' => 'Online',
                'start_date' => now()->addWeeks(3)->toDateString(),
                'end_date' => now()->addMonths(1)->toDateString(),
                'modules' => ['Discipline vs Punishment', 'Encouragement', 'Problem Solving', 'Natural Consequences'],
                'registration_fee' => 1500,
                'balance_fee' => 4500,
                'is_active' => true,
            ],
            [
                'title' => 'Counselling Skills Intensive',
                'category' => 'Counsellors',
                'description' => 'Sharpen core counselling skills including active listening, empathy mapping, goal setting, and reflective practice frameworks.',
                'location' => 'Prafulta Center',
                'start_date' => now()->addWeeks(6)->toDateString(),
                'end_date' => now()->addMonths(4)->toDateString(),
                'modules' => ['Active Listening', 'Empathy & Rapport', 'Goal Setting with Clients', 'Ethical Boundaries', 'Supervision Practice'],
                'registration_fee' => 5000,
                'balance_fee' => 15000,
                'is_active' => true,
            ],
            [
                'title' => 'Learning Disabilities: Identification & Support',
                'category' => 'Schools',
                'description' => 'Equip school teams to identify learning disabilities early and create structured support plans with teacher-parent collaboration.',
                'location' => 'Mumbai Center',
                'start_date' => now()->addWeeks(7)->toDateString(),
                'end_date' => now()->addMonths(3)->toDateString(),
                'modules' => ['LD Overview', 'Dyslexia & Dyscalculia', 'IEP Planning', 'Classroom Accommodations', 'Parent Communication'],
                'registration_fee' => 3000,
                'balance_fee' => 9000,
                'is_active' => true,
            ],
            [
                'title' => 'Speech & Language Essentials for Parents',
                'category' => 'Parents',
                'description' => 'Understand speech and language milestones, identify delays early, and learn home-based activities to support your child\'s communication growth.',
                'location' => 'Online',
                'start_date' => now()->addWeeks(2)->toDateString(),
                'end_date' => now()->addMonths(1)->addWeeks(2)->toDateString(),
                'modules' => ['Milestones', 'Red Flags', 'Home Activities', 'When to Seek Help'],
                'registration_fee' => 1200,
                'balance_fee' => 3600,
                'is_active' => true,
            ],
            [
                'title' => 'Play Therapy Foundations',
                'category' => 'Professionals',
                'description' => 'An introductory programme on child-centered play therapy – theory, techniques, setup, and case documentation for therapists.',
                'location' => 'Prafulta Center',
                'start_date' => now()->addMonth()->toDateString(),
                'end_date' => now()->addMonths(3)->toDateString(),
                'modules' => ['Play Therapy Theory', 'Setup & Materials', 'Directive vs Non-directive', 'Observation & Notes', 'Parent Feedback Sessions'],
                'registration_fee' => 4500,
                'balance_fee' => 13500,
                'is_active' => true,
            ],
            [
                'title' => 'Inclusive Education Policy & Practice',
                'category' => 'Schools',
                'description' => 'Navigate NEP 2020 inclusion mandates. Build actionable frameworks for school leadership to create truly inclusive environments.',
                'location' => 'Online + Mumbai Center',
                'start_date' => now()->addWeeks(8)->toDateString(),
                'end_date' => now()->addMonths(4)->toDateString(),
                'modules' => ['NEP 2020 Review', 'Inclusion Audit', 'Universal Design for Learning', 'Staff Training Plans', 'Monitoring & Evaluation'],
                'registration_fee' => 3500,
                'balance_fee' => 10500,
                'is_active' => true,
            ],
        ];

        foreach ($additionalProgrammes as $prog) {
            TrainingProgramme::query()->updateOrCreate(
                ['title' => $prog['title']],
                $prog
            );
        }

        $registrations = [
            [
                'training_programme_id' => $programmeA->id,
                'user_id' => $clients[0]->id,
                'participant_name' => $clients[0]->name,
                'email' => $clients[0]->email,
                'phone' => $clients[0]->phone,
                'address' => 'Pune',
                'form_data' => ['notes' => 'Need weekend batch.'],
                'status' => 'confirmed',
                'payment_status' => 'fully_paid',
                'registration_paid_amount' => 2500,
                'balance_paid_amount' => 7500,
            ],
            [
                'training_programme_id' => $programmeB->id,
                'user_id' => $clients[1]->id,
                'participant_name' => $clients[1]->name,
                'email' => $clients[1]->email,
                'phone' => $clients[1]->phone,
                'address' => 'Mumbai',
                'form_data' => ['notes' => 'Submitting documents later.'],
                'status' => 'approved',
                'payment_status' => 'registration_paid',
                'registration_paid_amount' => 3000,
                'balance_paid_amount' => 0,
            ],
            [
                'training_programme_id' => $programmeA->id,
                'user_id' => $clients[2]->id,
                'participant_name' => $clients[2]->name,
                'email' => $clients[2]->email,
                'phone' => $clients[2]->phone,
                'address' => 'Nashik',
                'form_data' => ['notes' => 'Requesting payment link on email.'],
                'status' => 'submitted',
                'payment_status' => 'pending',
                'registration_paid_amount' => 0,
                'balance_paid_amount' => 0,
            ],
        ];

        foreach ($registrations as $index => $registrationData) {
            $registration = TrainingRegistration::query()->updateOrCreate(
                ['training_programme_id' => $registrationData['training_programme_id'], 'email' => $registrationData['email']],
                $registrationData
            );

            if ($registrationData['registration_paid_amount'] > 0) {
                Payment::query()->updateOrCreate(
                    [
                        'training_registration_id' => $registration->id,
                        'payment_purpose' => 'training_registration',
                    ],
                    [
                        'booking_id' => null,
                        'method' => $index % 2 === 0 ? 'razorpay' : 'qr',
                        'status' => 'paid',
                        'amount' => $registrationData['registration_paid_amount'],
                        'transaction_reference' => 'TRN-REG-'.$registration->id,
                        'receipt_number' => 'TRN-RCPT-REG-'.$registration->id,
                        'meta' => ['seeded' => true],
                    ]
                );
            }

            if ($registrationData['balance_paid_amount'] > 0) {
                Payment::query()->updateOrCreate(
                    [
                        'training_registration_id' => $registration->id,
                        'payment_purpose' => 'training_balance',
                    ],
                    [
                        'booking_id' => null,
                        'method' => 'upi',
                        'status' => 'paid',
                        'amount' => $registrationData['balance_paid_amount'],
                        'transaction_reference' => 'TRN-BAL-'.$registration->id,
                        'receipt_number' => 'TRN-RCPT-BAL-'.$registration->id,
                        'meta' => ['seeded' => true],
                    ]
                );
            }
        }

        // Keep these known credentials seeded for quick admin access.
        User::query()->updateOrCreate(
            ['email' => 'client@prafulta.local'],
            ['password' => Hash::make('password')]
        );
        User::query()->updateOrCreate(
            ['email' => 'counsellor@prafulta.local'],
            ['password' => Hash::make('password')]
        );
        User::query()->updateOrCreate(
            ['email' => 'training@prafulta.local'],
            ['password' => Hash::make('password')]
        );
        User::query()->updateOrCreate(
            ['email' => 'admin@prafulta.local'],
            ['password' => Hash::make('password')]
        );
    }
}
