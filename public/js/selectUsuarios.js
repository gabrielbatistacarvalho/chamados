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