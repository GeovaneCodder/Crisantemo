$(document).ready(function(){    
    //Validando formulário do registro
     $( "#form_login" ).validate({
           rules: {
                   login_chave:
                   {
                        required: true,
                        minlength: 4,
                        maxlength: 25
                   },
                   
                   login_senha:
                   {
                        required: true,
                        minlength: 4,
                        maxlength: 20
                   }
                   
                },
           messages: {
                   login_chave:
                   {
                        required: " Chave de Acesso inválida! ",
                        minlength: $.format(" Chave de acesso muito curto, mínimo {0} characters! "),
                        maxlength: $.format(" Chave de acesso muito longo máximo {0} characters! ")
                   },
                   
                   login_senha:
                   {
                        required: " Senha inválida! ",
                        minlength: $.format(" Senha muito curto, mínimo {0} characters! "),
                        maxlength: $.format(" Senha muito longo máximo {0} characters! ")
                   }
                }
           });
    
    //Validando o formulário de registro
    $( "#reg_form" ).validate({
           rules: {
                   reg_nome:
                   {
                        required: true,
                        minlength: 4,
                        maxlength: 25
                   },
                   
                   reg_email_1:
                   {
                        required: true,
                        minlength: 6,
                        maxlength: 30,
                        email: true
                   },
                   
                   reg_email_2:
                   {
                        required: true,
                        minlength: 6,
                        maxlength: 30,
                        email: true,
                        equalTo: '#reg_email_1'
                   },
                   
                   reg_userid:
                   {
                        required: true,
                        minlength: 4,
                        maxlength: 20
                   },
                   
                   reg_senha_1:
                   {
                        required: true,
                        minlength: 4,
                        maxlength: 13
                   },
                   
                   reg_senha_2:
                   {
                        required: true,
                        minlength: 4,
                        maxlength: 13,
                        equalTo: '#reg_senha_1'
                   },
                   
                   reg_res_sec:
                   {
                        required: true,
                        minlength: 4,
                        maxlength: 13
                   },
				   
				   reg_codigo:
                   {
                        required: true,
                        minlength: 8,
                        maxlength: 8
                   }
           },
           messages: {
                   reg_nome:
                   {
                        required: " Coloque seu nome! ",
                        minlength: $.format(" Nome muito curto, mínimo {0} characters! "),
                        maxlength: $.format(" Nome muito longo máximo {0} characters! ")
                   },
                   
                   reg_email_1:
                   {
                        required: " Insira um E-Mail! ",
                        minlength: $.format(" Email muito curto, mínimo {0} characters! "),
                        maxlength: $.format("Email muito longo máximo {0} characters! "),
                        email: " E-Mail inválido! "
                   },
                   
                   reg_email_2:
                   {
                        required: " Confirme seu E-Mail! ",
                        minlength: $.format(" Email muito curto, mínimo {0} characters! "),
                        maxlength: $.format("Email muito longo máximo {0} characters! "),
                        email: " E-Mail inválido! ",
                        equalTo: " E-Mail's desiguais! "
                   },
                   
                   reg_userid:
                   {
                        required: " Insira um UserID! ",
                        minlength: $.format(" UserID muito curto, mínimo {0} characters! "),
                        maxlength: $.format(" UserID muito longo máximo {0} characters! ")
                   },
                   
                   reg_senha_1:
                   {
                        required: " Insira uma senha! ",
                        minlength: $.format(" Senha muito curta, mínimo {0} characters! "),
                        maxlength: $.format(" Senha muito longa máximo {0} characters! ")
                   },
                   
                   reg_senha_2:
                   {
                        required: " Confime sua senha! ",
                        minlength: $.format(" Senha muito curta, mínimo {0} characters! "),
                        maxlength: $.format(" Senha muito longa máximo {0} characters! "),
                        equalTo: " Senhas desiguais! "
                   },
                   
                   reg_res_sec:
                   {
                        required: " Insira sua resposta ",
                        minlength: $.format(" Resposta muito curta, mínimo {0} characters! "),
                        maxlength: $.format(" Resposta muito longa máximo {0} characters! ")
                   },
				   
				   reg_codigo:
                   {
                        required: " Insira o código de segurança ",
                        minlength: $.format(" código muito curta, mínimo {0} characters! "),
                        maxlength: $.format(" código muito longa máximo {0} characters! ")
                   }
           }
   });
   
   
   $("#adicionarcarrinho").click(function(){
   
		var teste	=	$("#item_id").html();
		var user	=	$("#user").html();
		
		if( $("#item_total").val() == 0 ){
		
			var total	=	1;	
		} else {
		
			var total	=	$("#item_total").val();
		}
		
		
		$.post('../../Include/Carrinho/Ajax.php',{id_item: ''+teste, userid: ''+user, total_item: ''+total},function(data){
			alert(data);
			return false;
		});
   });
   
   
});