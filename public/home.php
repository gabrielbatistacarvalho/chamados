<?php 

include 'header.php'; 
$con       = db();
$idUsuario = $_SESSION['idUsuario'];
$idEmpresa = $_SESSION['idEmpresa'];

if($_SESSION['nivel'] === "COMUM"){
    $filtro = "AND (a.IdUsuario = '$idUsuario')";

} elseif($_SESSION['nivel'] === "ADMIN") {
    $filtro = "AND (a.IdEmpresa = '$idEmpresa')";
} else {
    $filtro = "";
}

$sql     = "SELECT  a.*, 
                    b.Nome AS NomeEmpresa, 
                    c.Nome AS NomeUsuario 
                    FROM chamado AS a
                    INNER JOIN empresa AS b ON(a.IdEmpresa = b.IdEmpresa)
                    INNER JOIN usuario AS c ON(a.IdUsuario = c.IdUsuario)
                    WHERE (a.Excluido = 'N') 
                    $filtro
                    AND   (b.Excluido = 'N')
                    AND   (c.Excluido = 'N')
                    ORDER BY a.Prioridade, a.DataCriacao";
$select  = ($con->query($sql)) or die("ERRO SQL: select". $sql);

?>
<style> 

.card-body {
    min-height: 150px;
    padding-bottom: 5px;
}

</style>
<div class="container">
<div class="row mt-3">
    <div class="col-6">
        <h3>Chamados</h3>
    </div>
    <div class="col-6 text-end">
        <a href="chamadoIncluir.php" class="btn btn-primary" role="button" data-bs-toggle="submit">NOVO CHAMADO</a>
    </div>
</div>

    <div class="row">
        <?php while($chamado = mysqli_fetch_assoc($select)): ?>
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 div-card">
                <a href="#" style="text-decoration: none;" onclick="miniChamado('<?= encrypt($chamado['IdChamado']); ?>');">
                    <div class="card card-home mb-3 shadow rounded" style="max-width: 36rem;">
                        <div class="titulo-chamado titulo-<?= $chamado['Prioridade']; ?>">
                            <h5 class="card-title"><?= $chamado['Assunto']; ?></h5>
                        </div>
                        <div class="card-body text-black">
                            <p class="card-text paragrafo"><b>Empresa:</b> <?= $chamado['NomeEmpresa']; ?></p>
                            <p class="card-text paragrafo"><b>Criado por:</b> <?= $chamado['NomeUsuario']; ?></p>
                            <p class="card-text text-truncate paragrafo"><?= $chamado['Descricao']; ?></p>
                        </div>
                        <div class="card-data text-black paragrafo">
                                <?= (dataPadrao($chamado['DataCriacao'])); ?> às <?= (horaPadrao($chamado['HoraCriacao'])); ?>
                        </div>
                    </div>
                </a>
            </div>
        <?php endwhile ?>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalChamado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header" id="divHeader"></div>
            <div class="modal-body" id="divConteudo"></div>
            <div class="modal-footer" id="divBotao">
                <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="toggleModal('#modalChamado');">Fechar</button>
                <a class="btn btn-primary" id="btnEditar" role="button" data-bs-toggle="submit">Editar</a>
            </div>
        </div>
    </div>
</div>


<?php include 'footer.php'; ?>