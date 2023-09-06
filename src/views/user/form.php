<nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/user/list/<?= (isset($data['user']) === true) ? $data['id_company'] : $GLOBALS['id_company']; ?>">Usuário</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $data['title']; ?></li>
    </ol>
</nav>

<div class="d-flex flex-column justify-content-center align-items-center">
    <div class="card width-form">
        <div class="card-header text-center">
            <h2><?= $data['title']; ?></h2>
        </div>
        <div class="card-body">
            <form action="/user/<?= $data['action']; ?>" method="POST" id="formUser">
                <input id="id_empresa" name="id_empresa" type="hidden" value="<?= (isset($data['user']) === true) ? $data['user']['id_empresa'] : $data['id_company']; ?>">
                <input id="id_usuario" name="id_usuario" type="hidden" value="<?= (isset($data['user']) === true) ? $this->encrypt($data['user']['id_usuario']) : '0'; ?>">
                <input id="senha" name="senha" type="hidden" value="<?= (isset($data['user']) === true) ? $data['user']['senha'] : ''; ?>">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="nome" name="nome" obrigatorio="true" nome-validar="Nome" placeholder="Nome do usuário" maxlength="55" value="<?= (isset($data['user']) === true) ? $data['user']['nome'] : ''; ?>">
                            <label for="nome">Nome</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="email" name="email" obrigatorio="true" nome-validar="Email" placeholder="E-mail" maxlength="55" value="<?= (isset($data['user']) === true) ? $data['user']['email'] : ''; ?>">
                            <label for="email">E-mail</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control celullar" id="whatsapp" name="whatsapp" obrigatorio="true" nome-validar="Whatsapp" placeholder="Whatsapp" value="<?= (isset($data['user']) === true) ? $data['user']['whatsapp'] : ''; ?>">
                            <label for="whatsapp">Whatsapp</label>
                        </div>
                    </div>    
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <input type="checkbox" class="btn-check" id="resetSenha" name="resetSenha" autocomplete="off">
                            <label class="btn btn-outline-warning" for="resetSenha">RESETAR SENHA</label>
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <a class="btn btn-danger" href="/user/list/<?= $data['id_company']; ?>" role="button">CANCELAR</a>
                    <button id="btnSalvar" name="btnSalvar" type="submit" style="width: 112px;" preloader="true" onclick="return validateDataUser(this);" class="btn btn-primary">SALVAR</button>
                </div>
            </form>
        </div>
    </div>

</div>