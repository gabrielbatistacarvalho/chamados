function selectUsuarios(empresa, origem = "campo", idUsuario = null)
{
    var idEmpresa;
    (origem === "campo") ? idEmpresa = empresa.value : idEmpresa = empresa;
    
    $.post("https://chamados.gabrielcarvalho.site/ajax/buscaUsuarios.php?&IdEmpresa="+idEmpresa, "IdEmpresa="+idEmpresa, function(arrayUsuarios) {
        // Log the response to the console
        if(arrayUsuarios)
        {
            var usuarios = arrayUsuarios.split("|");
            // Selecionar o elemento select pelo ID
            var select = document.getElementById("usuario");
            var label  = document.getElementById("labelUsuario");
            select.style.display = "block";
            label.style.display  = "block";
            select.disabled      = false;
            select.innerHTML     = "";
            var option           = document.createElement("option");
            option.value         = "T";
            option.text          = "SELECIONE...";
            select.appendChild(option);
            usuarios.forEach(usuario => {
                var infoUsuario = usuario.split("-");
                var option      = document.createElement("option");
                option.value    = infoUsuario[0];
                option.text     = infoUsuario[1];
                option.selected = (infoUsuario[0] == idUsuario) ? true : false; 
                select.appendChild(option);
            });
        }
    });
}

function verificaArquivo($input) {
    var extPermitidas    = document.getElementById('extensoes').value.split(',');
    var extArquivo       = $input.value.split('.').pop();
    var fileSize         = $input.files[0].size;
    var maxSize          = 6291456;
    var textNotification = null; 
    var status           = true;
        
    if(typeof extPermitidas.find(function(ext){ return extArquivo == ext; }) == 'undefined') {
        textNotification = 'Extensão "' + extArquivo + '" não permitida!';
        $input.value     = null;
        status           = false;
    } else if(fileSize > maxSize) {
        textNotification = 'Arquivo excedeu o tamanho maximo de 6mb';
        $input.value     = null; 
        status           = false;
    } 
    if(textNotification != null)
    {
        notification('warning','Aviso!', textNotification);
        status = false;
    }
    createMiniatura(status);
}

function deleteAnexo(idAnexo, idUsuario)
{   
    Swal.fire({
        title: 'Aviso!',
        text: 'Quer mesmo excluir este anexo?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("https://chamados.gabrielcarvalho.site/ajax/excluiAnexo.php?&IdAnexo="+idAnexo+"&IdUsuario="+idUsuario, "IdAnexo="+idAnexo, function(resposta) {
            // Log the response to the console
            console.log("https://chamados.gabrielcarvalho.site/ajax/excluiAnexo.php?&IdAnexo="+idAnexo+"&IdUsuario="+idUsuario);
            
                if(resposta == true)
                {
                    window.location.reload(true);
                    /*
                    document.getElementById("inputAnexo").style.display     = "none";
                    document.getElementById("miniaturaAnexo").style.display = "none";
                    document.getElementById("exibeAnexo").style.display     = "block";
                    */
                }
                else
                {
                    console.log(resposta);
                    notification('warning','Aviso!', 'Não foi possível concluir a exclusão do anexo!<BR> Tente novamente mais tarde.');
                }
            });
        }
    })    
}

function createMiniatura(status)
{
    if(status === true)
    {
        const tgt = window.event.srcElement;

        const files = tgt.files;

        const fr = new FileReader();

        fr.onload = function () {
            document.getElementById('preview-image').style.display = "block";
            document.getElementById('preview-image').src = fr.result;
        }

        fr.readAsDataURL(files[0]);
    }
    else
    {
        document.getElementById('preview-image').style.display = "none";
        document.getElementById('preview-image').src = null;
    }   
}

function exibeImagem(input)
{
    if(input != "")
    {
        Swal.fire({
            imageUrl: input
        });
    }
}

function miniChamado(input)
{
    $.post("https://chamados.gabrielcarvalho.site/ajax/buscaChamado.php?&IdChamado="+input, "IdChamado="+input, function(resposta) {
    // Log the response to the console
    //console.log(resposta);  
    if(resposta != "fail")
    {
        /*
        ORDEM DOS CAMPOS - 
        0 - Assunto 
        1 - Descricao 
        2 - Usuario 
        3 - Empresa 
        4 - Data 
        5 - Hora 
        6 - Prioridade 
        7 - Status 
        8 - LinkAnexo 
        9 - IdChamado criptografado
        */
        var data     = resposta.split("|");
        var anexo    = (data[8] == "false") ? "" : '<img src="'+ data[8] +'" alt="" style="width: 80%; height: 80%;" id="preview-image"></img>';
        var header   = document.getElementById("divHeader");
        var conteudo = document.getElementById("divConteudo"); 
        var editar  = document.getElementById("btnEditar");
        var html =  '<div class="card-body" style="">'+
                        '<p class="card-text"><b>Empresa: </b>'+ data[3]+'</p>'+
                        '<p class="card-text"><b>Criado por: </b>'+ data[2] +' em '+ data[4] +' às '+ data[5] +'</p>'+
                        '<p class="card-text"><b>Prioridade: </b>'+ data[6] + '&emsp;  <b>Status: </b>'+ data[7] +'</p>'+
                        '<p class="card-text"><b>Descrição: </b>'+ data[1] +'</p>'+
                        anexo+
                    '</div>';
        header.innerHTML   = '<h5 class="card-title">'+ data[0] +'</h5>';
        conteudo.innerHTML = html;
        editar.href = "chamadoIncluir.php?IdChamado="+data[9];
        $('#modalChamado').modal('show');
          
    }
    else
    {
        console.log(resposta);
        notification('warning','Aviso!', 'Não foi possível carregar os dados deste chamado.');
    }
    });
}

function toggleModal($input)
{
    $($input).modal('toggle');
}

function pushEmail($dados)
{          
    $dados = JSON.stringify($dados);
            
    console.log($dados);
            
    // Faz a requisição POST
    $.post("https://email.gabrielcarvalho.site/enviarEmail.php", $dados
    , function(response) {
       //console.log(response);
    }
    );
}

function redefinirSenha($idUsuario) 
{
    $dados = JSON.stringify({"idUsuario":$idUsuario});
    // Faz a requisição POST
    $.post("https://chamados.gabrielcarvalho.site/ajax/redefinirSenha.php", $dados
    , function(response) {
       console.log(response);
    }
    );
}