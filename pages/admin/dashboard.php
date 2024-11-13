<?php
require_once "../../include/config/session.php";
if (!isset($_SESSION['id_user']) && $_SESSION['role'] !== "admin") {
    header("Location: login/sigin.php");
    exit;
}
$scripts = ["color-switch.js", "hamburger-menu.js", "admin/tabs.js", "admin/delete.js"];

$title = "Panel de Administración";
$styles = "admin.css";
include_once "../../include/head.php";
require_once "../../include/config/database.php";
$pdo = getDatabaseConnection();
?>

<body>
    <?php
    include_once "../../include/header.php";
    ?>

    <div class="admin-container">
        <div class="sidebar">
            <ul>
                <li><a href="#misiones" class="tab-link">Misiones</a></li>
                <li><a href="#noticias" class="tab-link">Noticias</a></li>
                <li><a href="#usuarios" class="tab-link">Usuarios</a></li>
                <li><a href="#agencias" class="tab-link">Agencias Espaciales</a></li>
                <li><a href="#objetos_celestes" class="tab-link">Objetos Celestes</a></li>
                <li><a href="#tipos_mision" class="tab-link">Tipos de Misión</a></li>
            </ul>
        </div>

        <div class="content">
            <!-- Sección de Misiones -->
            <section id="misiones" class="section">
                <h2>Misiones</h2>
                <a href="../missions/create_mission.php" class="button  button-background">Crear Nueva Misión</a>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre de Misión</th>
                            <th>Estado</th>
                            <th>Fecha de Lanzamiento</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT m.id_mission, m.name, s.name AS status, m.launch_date, slug
                                FROM mission m JOIN status s ON m.id_status = s.id_status WHERE m.is_deleted IS FALSE";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                        $missions = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($missions as $mission) {
                            ?>
                            <tr id="mission-<?= $mission['id_mission'] ?>">
                                <td><?= $mission['id_mission'] ?></td>
                                <td><?= $mission['name'] ?></td>
                                <td><?= $mission['status'] ?></td>
                                <td><?= $mission['launch_date'] ?></td>
                                <td><a href="../missions/edit_mission/<?= $mission['slug'] ?>"
                                        class="action-button edit-button"><img src="../../images/Admin/edit.svg"></a>
                                    <img src="../../images/Admin/delete.svg"
                                        class="action-button delete-button delete-mission-btn"
                                        data-id="<?= $mission['id_mission'] ?>">
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </section>

            <!-- Sección de Noticias -->
            <section id="noticias" class="section">
                <h2>Noticias</h2>
                <a href="../news/create_new.php" class="button  button-background">Crear Nueva Noticia</a>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título de la Noticia</th>
                            <th>Autor</th>
                            <th>Fecha de Publicación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT id_new, title, u.username, published_at, slug 
                                FROM news n JOIN users u ON u.id_user = n.id_author";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                        $news = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($news as $new) {
                            ?>
                            <tr>
                                <td><?= $new['id_new'] ?></td>
                                <td><?= $new['title'] ?></td>
                                <td><?= $new['username'] ?></td>
                                <td><?= $new['published_at'] ?></td>
                                <td><a href="../edit_new/<?= $new['slug'] ?>" class="action-button edit-button"><img
                                            src="../../images/Admin/edit.svg"></a>
                                    <a href="eliminar_mision.php?id=<?= $new['id_new'] ?>"
                                        class="action-button delete-button"><img src="../../images/Admin/delete.svg"></a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </section>

            <!-- Sección de Usuarios -->
            <section id="usuarios" class="section">
                <h2>Usuarios</h2>
                <a href="crear_usuario.php" class="button  button-background">Crear Nuevo Usuario</a>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre de Usuario</th>
                            <th>Correo</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT id_user, username, email, role FROM users WHERE is_deleted IS FALSE";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($users as $user) {
                            ?>
                            <tr>
                                <td><?= $user['id_user'] ?></td>
                                <td><?= $user['username'] ?></td>
                                <td><?= $user['email'] ?></td>
                                <td><?= $user['role'] ?></td>
                                <td><a href="editar_mision.php?id=<?= $user['id_user'] ?>"
                                        class="action-button edit-button"><img src="../../images/Admin/edit.svg"></a>
                                    <a href="eliminar_mision.php?id=<?= $user['id_user'] ?>"
                                        class="action-button delete-button"><img src="../../images/Admin/delete.svg"></a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </section>

            <!-- Sección de Agencias Espaciales -->
            <section id="agencias" class="section">
                <h2>Agencias Espaciales</h2>
                <a href="crear_agencia.php" class="button  button-background">Crear Nueva Agencia</a>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre de Agencia</th>
                            <th>Logo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT id_agency, name, logo FROM space_agency WHERE is_deleted IS FALSE";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                        $agencies = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($agencies as $agency) {
                            ?>
                            <tr>
                                <td><?= $agency['id_agency'] ?></td>
                                <td><?= $agency['name'] ?></td>
                                <td><img src="../../images/SpaceAgencies/<?= $agency['logo'] ?>"></td>
                                <td><a href="editar_mision.php?id=<?= $agency['id_agency'] ?>"
                                        class="action-button edit-button"><img src="../../images/Admin/edit.svg"></a>
                                    <a href="eliminar_mision.php?id=<?= $agency['id_agency'] ?>"
                                        class="action-button delete-button"><img src="../../images/Admin/delete.svg"></a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </section>

            <!-- Sección de Objetos Celestes -->
            <section id="objetos_celestes" class="section">
                <h2>Objetos Celestes</h2>
                <a href="crear_objeto_celeste.php" class="button  button-background">Crear Nuevo Objeto Celeste</a>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Logo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT id_celestial_object, name, logo FROM celestial_object WHERE is_deleted IS FALSE";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                        $celestial_objects = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($celestial_objects as $celestial_object) {
                            ?>
                            <tr>
                                <td><?= $celestial_object['id_celestial_object'] ?></td>
                                <td><?= $celestial_object['name'] ?></td>
                                <td><img src="../../images/Missions/Logos/<?= $celestial_object['logo'] ?>"></td>
                                <td><a href="editar_mision.php?id=<?= $celestial_object['id_celestial_object'] ?>"
                                        class="action-button edit-button"><img src="../../images/Admin/edit.svg"></a>
                                    <a href="eliminar_mision.php?id=<?= $celestial_object['id_celestial_object'] ?>"
                                        class="action-button delete-button"><img src="../../images/Admin/delete.svg"></a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </section>

            <!-- Sección de Tipos de Misión -->
            <section id="tipos_mision" class="section">
                <h2>Tipos de Misión</h2>
                <a href="crear_tipo_mision.php" class="button  button-background">Crear Nuevo Tipo de Misión</a>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Logo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT id_mission_type, name, logo FROM mission_type WHERE is_deleted IS FALSE";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                        $mission_types = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($mission_types as $mission_type) {
                            ?>
                            <tr>
                                <td><?= $mission_type['id_mission_type'] ?></td>
                                <td><?= $mission_type['name'] ?></td>
                                <td><img src="../../images/Missions/Icons/<?= $mission_type['logo'] ?>"></td>
                                <td><a href="editar_mision.php?id=<?= $mission_type['id_mission_type'] ?>"
                                        class="action-button edit-button"><img src="../../images/Admin/edit.svg"></a>
                                    <a href="eliminar_mision.php?id=<?= $mission_type['id_mission_type'] ?>"
                                        class="action-button delete-button"><img src="../../images/Admin/delete.svg"></a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
    <?php
    include_once "../include/footer.php";
    ?>