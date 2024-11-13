<?php
function userHasRole($requiredRole)
{
    return isset($_SESSION['role']) && $_SESSION['role'] === $requiredRole;
}