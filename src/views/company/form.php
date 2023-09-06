<nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/company/list">Empresas</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $data['title']; ?></li>
    </ol>
</nav>

<div class="d-flex flex-column justify-content-center align-items-center">
    <div class="card width-form">
        <div class="card-header text-center">
            <h2><?= $data['title']; ?></h2>
        </div>
        <div class="card-body">
            <form action="/company/<?= $data['action']; ?>" method="POST" id="formCompany">
                <input id="id_empresa" name="id_empresa" type="hidden" value="<?= (isset($data['id_company']) === true) ? $data['id_company'] : '0'; ?>">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="nome" name="nome" obrigatorio="true" nome-validar="Nome" placeholder="Nome da empresa" maxlength="55" value="<?= (isset($data['company']) === true) ? $data['company']['nome'] : ''; ?>">
                            <label for="nome">Nome</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control cnpj" id="cnpj" name="cnpj" obrigatorio="true" nome-validar="CNPJ" placeholder="CNPJ" value="<?= (isset($data['company']) === true) ? $data['company']['cnpj'] : ''; ?>">
                            <label for="cnpj">CNPJ</label>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control celullar" id="whatsapp" name="whatsapp" obrigatorio="true" nome-validar="Whatsapp" placeholder="Whatsapp" value="<?= (isset($data['company']) === true) ? $data['company']['whatsapp'] : ''; ?>">
                            <label for="whatsapp">Whatsapp</label>
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <a class="btn btn-danger" href="/company/list" role="button">CANCELAR</a>
                    <button id="btnSalvar" name="btnSalvar" type="submit" style="width: 112px;" preloader="true" onclick="return validateDataCompany(this);" class="btn btn-primary">SALVAR</button>
                </div>
            </form> 
        </div>
    </div>

</div>