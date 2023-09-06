<?php 

include 'header.php'; 

$filtro = "";
$titulo = "";
$link   = "";

if($_SESSION['nivel'] === "COMUM"){
    header("Location: home.php");

    die();
} else if($_SESSION['nivel'] === "ADMIN"){
    $filtro = "(a.IdEmpresa = '".$_SESSION['idEmpresa']."') AND";
} 

$con = db();

if(isset($_GET['IdEmpresa'])){
    $idEmpresa   = decrypt($_GET['IdEmpresa']);
    $filtro      = "(a.IdEmpresa = '$idEmpresa') AND";
    $link        = "?&IdEmpresa=".encrypt($idEmpresa);
    $sqlEmpresa  = "SELECT Nome FROM empresa WHERE (IdEmpresa = '$idEmpresa') AND (Excluido = 'N')";
    $nomeEmpresa = mysqli_fetch_assoc($con->query($sqlEmpresa));
    $titulo      = " > ".$nomeEmpresa['Nome'];
} else {
    $idEmpresa = $_SESSION['idEmpresa'];
}

$sql  = "SELECT a.*, b.Nome AS NomeEmpresa
         FROM usuario AS a
         INNER JOIN empresa AS b ON (a.IdEmpresa = b.IdEmpresa)
         WHERE $filtro (a.Excluido = 'N')
         AND   (b.Excluido = 'N')
         ORDER BY a.Nome ASC";
$data = $con->query($sql);
$num_rows = mysqli_num_rows($data); 

?>

<div class="row mt-3">
    <div class="col-6">
        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Usuários</li>
            </ol>
        </nav>
    </div>
    <div class="col-6 text-end">
        <a href="home.php" class="btn btn-warning" role="button"><i class="bi bi-arrow-left-square"></i></a>
        <a href="usuarioIncluir.php<?= $link ?>" class="btn btn-primary" role="button" data-bs-toggle="submit">NOVO USUÁRIO</a>
    </div>
</div>

    <?php if($num_rows > 0): ?>
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th scope="col" style="width: 50px;">ID</th>
                <th scope="col">NOME</th>
                <th scope="col" style="width: 150px;">EMAIL</th>
                <th scope="col" style="width: 180px;">TELEFONE</th>
                <th scope="col" style="width: 200px;">EMPRESA</th>
                <th scope="col" style="width: 70px;">STATUS</th>
                <th scope="col" style="width: 190px;">CRIADO EM</th>
                <th scope="col" style="width: 10px;"></th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php while($user = mysqli_fetch_assoc($data)): ?>
                <tr>
                    <th scope="row"><?= $user['IdUsuario']; ?></th>
                    <td><?= $user['Nome']; ?></td>
                    <td><?= $user['Email']; ?></td>
                    <td><?= maskPhone($user['Telefone']); ?></td>
                    <td><?= $user['NomeEmpresa']; ?></td>
                    <td><?= ($user['Status'] == 'A') ? 'Ativa' : 'Inativa'; ?></td>
                    <td><?= dataPadrao($user['DataCriacao']).' às '.$user['HoraCriacao']; ?></td>
                    <td>
                        <div class="btn-group">
                            <button class="btn dropdown-toggle dropdown-rounded" type="button" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical text-primary"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="usuarioIncluir.php<?= $link; ?>?IdUsuario=<?= encrypt($user['IdUsuario']); ?>">
                                        <i class="bi bi-pencil"></i>
                                        <span>Alterar</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                <?php endwhile ?>
        </tbody>
        <?php else: ?>
        <tfoot>
            <tr>
                <td colspan="6" class="border-bottom-0">
                    <div class="d-flex justify-content-center">
                        <div class="alert alert-danger text-center w-100" role="alert">
                            NENHUM USUÁRIO CADASTRADO!
                        </div>
                    </div>
                </td>
            </tr>
        </tfoot>
        <?php endif; ?>
</table>

<?php include 'footer.php'; ?>