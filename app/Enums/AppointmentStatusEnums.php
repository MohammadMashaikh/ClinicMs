<?php

namespace App\Enums;

enum AppointmentStatusEnums: string
{
    case PENDING = "Pending";
    case CONFIRMED = "Confirmed";
    case IN_PROGRESS = "In Progress";
    CASE COMPLETED = "Completed";
    CASE CANCELLED = "Cancelled";
}
