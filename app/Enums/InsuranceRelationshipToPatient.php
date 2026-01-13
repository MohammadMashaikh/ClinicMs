<?php
namespace App\Enums;

enum InsuranceRelationshipToPatient: string {

    case SELF = "Self";
    case SPOUSE = "Spouse";
    case PARENT = "Parent";
    case CHILD = "Child";
    case OTHER = "Other";

}