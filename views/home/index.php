<!doctype html>
<html class="no-js" lang="">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Lista de Tarefas</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet"  type="text/css" href="../../public/css/diario.css">		
	</head>
	<body>
		<header>			
			<nav class="navbar navbar-expand-lg" style="border:1px">
				<div style="">
					<br>
					<h1 style="margin-left:15%"> LISTA DE TAREFAS </h1>
				</div>
				<div style="margin-left:5%;width:70%;">
					<br>
					<h5 style="color:green;font-family:Courier New, monospace;margin-top:10px;"> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp {  LISTA DE TAREFAS PARA PROGRAMADORES, CRUD DE ANOTAÇÕES }</h5>
					
				</div>	
				<div style="margin-left:1%;width:10%">
					<br>
					<!-- <h5 style="">RELOGIO <i class="fa fa-plus"></i></h5> -->
					<h5 style="font-size:16px" ><b><?=$this->data_atual->format("d/m/Y");?></b> <b id="hora"></b></h5>
				</div>					
			</nav>      	
		</header>
        <hr>
        <br>       			 
		<section class="content">
			<div style="margin-left:10%">
				<h6>Tarefa:</h6>				                   
				<form id="form_list">
					<textarea type="text" name="tarefa" placeholder="Informe uma tarefa ?" style="width:87%;height:150px"></textarea> 
					<div>
						<button type="button" id="enviar">Enviar</button> 
					</div>      
				</form>
			</div>
		</section>
		<br></br> 
		<?php foreach($tarefas as $key => $value){ ?> 			
			<section class='content'>
				<div style="margin-left:10%;margin-right:12%">
					<text style="width:100%;font-size:14px"> <b style=""> TAREFA POSTADA EM: </B> <?=convertDate($value->alterado_em);?> </text>
					<form class='form' id='form_<?=$value->id;?>'>
						<input type="text" value="<?=$value->tarefa;?>" name="tarefa" style="height:100px;width:100%;text-align:center"> 
					</form>	
					<div style="margin-top:5px">
						<button type="button" class='botao' name='update' value="<?="update/".$value->id?>"> Editar </button>
						<button type="button" class='botao' name='delete' value="<?="delete/".$value->id?>"> Excluir </button>
					</div>
				</div>
				<br>
			</section>
		<?php } ?>
		<br></br>
    </body>


	<?php include 'template/scripts.inc' ?>
	<script type="text/javascript">
		$("#enviar").click(function(){
			requiscaoAjax("create",null,"form_list");				
		});

		$(".botao").click(function(){
			value 	   = $(this).val();
			argumentos = value.split("/");
			if(argumentos[0] == "delete"){
				requiscaoAjax("delete",argumentos[1]);	
			}else{
				requiscaoAjax("update",argumentos[1],"form_"+argumentos[1]);
			}			
		});

		function requiscaoAjax(metodo, id = null, form = null){
			url  = "<?= HOME_URI.$this->nome_modulo?>/"+metodo+"/"+id;
			if(form != null){
				form = $("#"+form).serialize();
			}			
			$.ajax({
				url: url,
				data : form,
				type: 'POST',				
                success: function(data){                    
                    retorno = JSON.parse(data);					
                    if(retorno.codigo == 0){ 			
						alert(retorno.mensagem); 
						window.location.reload();            
                    }else{						
						alert(retorno.mensagem);     
						window.location.reload();                                       
                    }
                },
                erro: function(error){
					alert(retorno.mensagem);    
                }
			});	
		}

		function time(){
           data    = new Date();
		   hora    = data.getHours();
		   minuto  = data.getMinutes();
		   segundo = data.getSeconds();		   					 
		   if(hora < 10){
			   hora = "0"+hora;
		   }
		   if(minuto < 10){
			   minuto = "0"+minuto;
		   }
		   if(segundo < 10){
			   segundo = "0"+segundo;
		   }

		   relogio = hora+":"+minuto+":"+segundo;
		   console.log((relogio));
		  
		   document.getElementById("hora").innerText = relogio;
		  
	   }      
	   var intervalo = setInterval(time, 1000);
	</script>
</html>
