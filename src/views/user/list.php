<?php $GLOBALS['id_company'] = $data['id_company']; ?>
<div class="row mt-3">
    <div class="col-6">
        <h2>Usuários</h2>
    </div>
    <div class="col-6 text-end">
        <a href="/company/list" class="btn btn-warning" role="button"><i class="bi bi-arrow-left-square"></i></a>
        <a href="/user/render/<?= $data['id_company']; ?>" class="btn btn-primary" role="button" data-bs-toggle="submit">NOVO USUÁRIO</a>
    </div>
</div>

<table class="table table-hover align-middle">
    <thead>
        <tr>
            <th scope="col" style="width: 50px;">ID</th>
            <th scope="col">NOME</th>
            <th scope="col">E-MAIL</th>
            <th scope="col" style="width: 250px;">WHATSAPP</th>
            <th scope="col" style="width: 50px;"></th>
        </tr>
    </thead>
    <?php if(empty($data['users'] === false)): ?>
        <tbody class="table-group-divider">
            <?php foreach($data['users'] as $user): ?>
                <tr>
                    <th scope="row"><?= $user['id_usuario']; ?></th>
                    <td><?= $user['nome']; ?></td>
                    <td><?= $user['email']; ?></td>
                    <td><?= $user['whatsapp']; ?></td>
                    <td>
                        <div class="btn-group">
                            <button class="btn dropdown-toggle dropdown-rounded" type="button" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical text-primary"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="/user/render/<?= $data['id_company']; ?>/<?= $this->encrypt($user['id_usuario']); ?>">
                                        <i class="bi bi-pencil"></i>
                                        <span>Alterar</span>
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
                            NENHUM USUÁRIO CADASTRADO!
                        </div>
                    </div>
                </td>
            </tr>
        </tfoot>
        <?php endif; ?>
</table>