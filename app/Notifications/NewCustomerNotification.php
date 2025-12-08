<?php

namespace App\Notifications;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCustomerNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected Customer $customer;
    protected $creator;
    protected string $action = 'created';

    public function __construct(Customer $customer, $creator = null, string $action = 'created')
    {
        $this->customer = $customer;
        $this->creator = $creator;
        $this->action = $action;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mailMessage = (new MailMessage)
            ->subject('New Customer: ' . $this->customer->name)
            ->line('A new customer has been added: ' . $this->customer->name)
            ->line('Created by: ' . ($this->creator->name ?? 'System'))
            ->action('View Customer', url('/customers/' . $this->customer->id))
            ->line('Thank you for using ImpactGuru CRM');
        
        // Send from the creator's email address if available
        if ($this->creator && $this->creator->email) {
            $mailMessage->from($this->creator->email, $this->creator->name);
        }
        
        return $mailMessage;
    }

    public function toArray(object $notifiable): array
    {
        $message = $this->action === 'deleted'
            ? "Customer {$this->customer->name} deleted"
            : "Customer {$this->customer->name} created";

        return [
            'customer_id' => $this->customer->id,
            'action' => $this->action,
            'message' => $message,
            'created_by_id' => $this->creator->id ?? null,
            'created_by_name' => $this->creator->name ?? null,
        ];
    }
}
