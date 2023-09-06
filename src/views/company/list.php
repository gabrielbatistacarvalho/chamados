<div class="row mt-3">
    <div class="col-6">
        <h2>Empresas</h2>
    </div>
    <div class="col-6 text-end">
        <a href="/home" class="btn btn-warning" role="button"><i class="bi bi-arrow-left-square"></i></a>
        <a href="render" class="btn btn-primary" role="button" data-bs-toggle="submit">NOVA EMPRESA</a>
    </div>
</div>

<table class="table table-hover align-middle">
    <thead>
        <tr>
            <th scope="col" style="width: 50px;">ID</th>
            <th scope="col">NOME</th>
            <th scope="col" style="width: 250px;">CNPJ</th>
            <th scope="col" style="width: 50px;"></th>
        </tr>
    </thead>
    <?php if(empty($data['companies'] === false)): ?>
        <tbody class="table-group-divider">
            <?php foreach($data['companies'] as $company): ?>
                <tr>
                    <th scope="row"><?= $company['id_empresa']; ?></th>
                    <td><?= $company['nome']; ?></td>
                    <td><?= $this->maskCnpj($company['cnpj']); ?></td>
                    <td>
                        <div class="btn-group">
                            <button class="btn dropdown-toggle dropdown-rounded" type="button" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical text-primary"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="render/<?= $this->encrypt($company['id_empresa']); ?>">
                                        <i class="bi bi-pencil"></i>
                                        <span>Alterar</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="/user/list/<?= $this->encrypt($company['id_empresa']); ?>">
                                        <i class="bi bi-people-fill"></i>
                                        <span>Usuários</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                <?php endforeach;?>
        </tbody>
        <?php else: ?>
        <tfoot>
            <tr>
                <td colspan="4" class="border-bottom-0">
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