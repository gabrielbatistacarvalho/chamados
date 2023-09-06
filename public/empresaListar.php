<?php 

include 'header.php'; 

if(($_SESSION['nivel'] === "ADMIN") or ($_SESSION['nivel'] === "COMUM")){
    header("Location: home.php");

    die();
}

$sql   = "SELECT * FROM empresa WHERE (Excluido = 'N')";

$con = db();
$data = $con->query($sql);
$num_rows = mysqli_num_rows($data); 

?>

<div class="row mt-3">
    <div class="col-6">
        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Empresas</li>
            </ol>
        </nav>
    </div>
    <div class="col-6 text-end">
        <a href="home.php" class="btn btn-warning" role="button"><i class="bi bi-arrow-left-square"></i></a>
        <a href="empresaIncluir.php" class="btn btn-primary" role="button" data-bs-toggle="submit">NOVA EMPRESA</a>
    </div>
</div>

    <?php if($num_rows > 0): ?>
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th scope="col" style="width: 100px;">ID</th>
                <th scope="col">NOME</th>
                <th scope="col" style="width: 200px;">TELEFONE</th>
                <th scope="col" style="width: 150px;">STATUS</th>
                <th scope="col" style="width: 250px;">CRIADO EM</th>
                <th scope="col" style="width: 50px;"></th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php while($company = mysqli_fetch_assoc($data)): ?>
                <tr>
                    <th scope="row"><?= $company['IdEmpresa']; ?></th>
                    <td><?= $company['Nome']; ?></td>
                    <td><?= maskPhone($company['Telefone']); ?></td>
                    <td><?= ($company['Status'] == 'A') ? 'Ativa' : 'Inativa'; ?></td>
                    <td><?= dataPadrao($company['DataCriacao']).' às '.$company['HoraCriacao']; ?></td>
                    <td>
                        <div class="btn-group">
                            <button class="btn dropdown-toggle dropdown-rounded" type="button" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical text-primary"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="empresaIncluir.php?&IdEmpresa=<?= encrypt($company['IdEmpresa']); ?>">
                                        <i class="bi bi-pencil"></i>
                                        <span>Alterar</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="usuarioListar.php?&IdEmpresa=<?= encrypt($company['IdEmpresa']); ?>">
                                        <i class="bi bi-people-fill"></i>
                                        <span>Usuários</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="chamadoIncluir.php?&IdEmpresa=<?= encrypt($company['IdEmpresa']); ?>">
                                        <i class="bi bi-people-fill"></i>
                                        <span>Novo chamado</span>
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
                            NENHUMA EMPRESA CADASTRADA!
                        </div>
                    </div>
                </td>
            </tr>
        </tfoot>
        <?php endif; ?>
</table>

<?php include 'footer.php'; ?>