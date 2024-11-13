<?php
function getMissionInfo(PDO $pdo, string $slug): ?array
{

    $sql = "SELECT id_mission, m.name, slug, launch_date, banner, description, s.name AS status, co.name AS celestial_object, co.logo AS celestial_object_logo,
            mt.name AS mission_type, mt.logo AS mission_type_logo, sa.name AS space_agency, sa.logo AS space_agency_logo
            FROM mission AS m 
            LEFT JOIN status AS s ON m.id_status = s.id_status
            LEFT JOIN celestial_object AS co ON m.id_celestial_object = co.id_celestial_object
            LEFT JOIN mission_type AS mt ON m.id_mission_type = mt.id_mission_type
            LEFT JOIN space_agency AS sa ON m.id_agency = sa.id_agency
            WHERE slug = :slug AND m.is_deleted IS FALSE";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["slug" => $slug]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

function getMissionDetails(PDO $pdo, string $id_mission)
{
    $sql = "SELECT launch_site, end_date, rocket_type, mission_duration, crew_size, budget, objectives, achievements
    FROM mission AS m 
    LEFT JOIN status AS s ON m.id_status = s.id_status
    LEFT JOIN celestial_object AS co ON m.id_celestial_object = co.id_celestial_object
    LEFT JOIN mission_type AS mt ON m.id_mission_type = mt.id_mission_type
    LEFT JOIN space_agency AS sa ON m.id_agency = sa.id_agency
    LEFT JOIN mission_details AS md ON m.id_mission_details = md.id_mission_details
    WHERE id_mission = :id_mission AND m.is_deleted IS FALSE";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["id_mission" => $id_mission]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

function getAllInfo(PDO $pdo, string $slug)
{
    $sql = "SELECT id_mission, m.name, slug, launch_date, banner, description, s.name AS status, co.name AS celestial_object, co.logo AS celestial_object_logo,
            mt.name AS mission_type, mt.logo AS mission_type_logo, sa.name AS space_agency, sa.logo AS space_agency_logo,
            launch_site, end_date, rocket_type, mission_duration, crew_size, budget, objectives, achievements
            FROM mission AS m 
            LEFT JOIN status AS s ON m.id_status = s.id_status
            LEFT JOIN celestial_object AS co ON m.id_celestial_object = co.id_celestial_object
            LEFT JOIN mission_type AS mt ON m.id_mission_type = mt.id_mission_type
            LEFT JOIN space_agency AS sa ON m.id_agency = sa.id_agency
            LEFT JOIN mission_details AS md ON m.id_mission_details = md.id_mission_details
            WHERE slug = :slug AND m.is_deleted IS FALSE";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["slug" => $slug]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}