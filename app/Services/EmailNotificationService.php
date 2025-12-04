<?php

namespace App\Services;

use App\Models\User;
use App\Models\RestockConfirmation;
use App\Models\Defect;
use App\Models\Supplier;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailNotificationService
{
    /**
     * Send welcome email to new user
     */
    public function sendWelcomeEmail(User $user, $password)
    {
        try {
            Mail::send('emails.welcome', [
                'user' => $user,
                'password' => $password,
                'loginUrl' => route('login'),
            ], function ($message) use ($user) {
                $message->to($user->email, $user->name)
                    ->subject('Welcome to NexStack Inventory Management System');
            });

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send welcome email: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send restock confirmation email to supplier
     */
    public function sendRestockConfirmationEmail(RestockConfirmation $restockConfirmation)
    {
        if (!$restockConfirmation->supplier) {
            return false;
        }

        try {
            $supplier = $restockConfirmation->supplier;
            $product = $restockConfirmation->product;

            Mail::send('emails.restock-confirmation', [
                'restockConfirmation' => $restockConfirmation,
                'supplier' => $supplier,
                'product' => $product,
            ], function ($message) use ($supplier, $product) {
                $message->to($supplier->email, $supplier->company_name)
                    ->subject("Restock Request for {$product->name} - NexStack");
            });

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send restock confirmation email: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send defect replacement request email to supplier
     */
    public function sendDefectReplacementEmail(Defect $defect)
    {
        if (!$defect->supplier) {
            return false;
        }

        try {
            $supplier = $defect->supplier;
            $product = $defect->product;

            Mail::send('emails.defect-replacement', [
                'defect' => $defect,
                'supplier' => $supplier,
                'product' => $product,
            ], function ($message) use ($supplier, $product) {
                $message->to($supplier->email, $supplier->company_name)
                    ->subject("Replacement Request for Defective {$product->name} - NexStack");
            });

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send defect replacement email: ' . $e->getMessage());
            return false;
        }
    }
}

