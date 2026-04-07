<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('counsellor_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('photo_path')->nullable();
            $table->text('bio')->nullable();
            $table->json('specializations')->nullable();
            $table->json('session_modes')->nullable();
            $table->unsignedInteger('session_duration_minutes')->default(60);
            $table->decimal('session_price', 10, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('counsellor_availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('counsellor_id')->constrained('users')->cascadeOnDelete();
            $table->date('available_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('is_available')->default(true);
            $table->string('source', 30)->default('self');
            $table->string('reason')->nullable();
            $table->timestamps();
        });

        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_reference')->unique();
            $table->foreignId('client_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('counsellor_id')->constrained('users')->cascadeOnDelete();
            $table->enum('service_type', ['regular_counselling', 'occupational_therapy', 'remedial_therapy']);
            $table->enum('session_mode', ['video', 'call', 'in_person'])->nullable();
            $table->dateTime('scheduled_at');
            $table->unsignedInteger('duration_minutes')->default(60);
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled', 'rescheduled'])->default('pending');
            $table->enum('payment_status', ['pending', 'paid', 'partial', 'refunded'])->default('pending');
            $table->decimal('amount', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->boolean('is_offline_booking')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('discount_coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('discount_type', ['fixed', 'percentage']);
            $table->decimal('value', 10, 2);
            $table->enum('service_type', ['regular_counselling', 'occupational_therapy', 'remedial_therapy', 'training'])->nullable();
            $table->unsignedInteger('usage_limit')->nullable();
            $table->unsignedInteger('used_count')->default(0);
            $table->timestamp('expires_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('cancellation_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->foreignId('requested_by')->constrained('users')->cascadeOnDelete();
            $table->text('reason')->nullable();
            $table->enum('status', ['pending', 'approved', 'declined'])->default('pending');
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('session_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->foreignId('counsellor_id')->constrained('users')->cascadeOnDelete();
            $table->longText('notes');
            $table->timestamps();
        });

        Schema::create('counsellor_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('counsellor_id')->constrained('users')->cascadeOnDelete();
            $table->date('attendance_date');
            $table->enum('status', ['present', 'absent']);
            $table->string('note')->nullable();
            $table->timestamps();
            $table->unique(['counsellor_id', 'attendance_date']);
        });

        Schema::create('training_programmes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category');
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->json('modules')->nullable();
            $table->decimal('registration_fee', 10, 2)->default(0);
            $table->decimal('balance_fee', 10, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('training_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_programme_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('participant_name');
            $table->string('email');
            $table->string('phone', 30);
            $table->text('address')->nullable();
            $table->json('form_data')->nullable();
            $table->enum('status', ['submitted', 'approved', 'cancelled', 'confirmed'])->default('submitted');
            $table->enum('payment_status', ['pending', 'registration_paid', 'fully_paid'])->default('pending');
            $table->decimal('registration_paid_amount', 10, 2)->default(0);
            $table->decimal('balance_paid_amount', 10, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('training_registration_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('payment_purpose', ['booking', 'training_registration', 'training_balance', 'refund']);
            $table->enum('method', ['razorpay', 'cash', 'qr', 'upi', 'cheque', 'bank_transfer']);
            $table->enum('status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->decimal('amount', 10, 2);
            $table->string('transaction_reference')->nullable();
            $table->string('receipt_number')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
        Schema::dropIfExists('training_registrations');
        Schema::dropIfExists('training_programmes');
        Schema::dropIfExists('counsellor_attendances');
        Schema::dropIfExists('session_notes');
        Schema::dropIfExists('cancellation_requests');
        Schema::dropIfExists('discount_coupons');
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('counsellor_availabilities');
        Schema::dropIfExists('counsellor_profiles');
    }
};
