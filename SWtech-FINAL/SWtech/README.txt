SWtech - Projeto PHP + MySQL

INSTALAÇÃO
1. Coloque esta pasta dentro de htdocs no XAMPP.
2. Ligue Apache e MySQL.
3. Importe banco.sql no phpMyAdmin.
4. Para uma instalação que já possui o banco antigo, execute atualizar_banco.sql uma única vez.
5. Confira app/cons.php: localhost, root, senha vazia e banco swtech.
6. Acesse http://localhost/SWtech/.

PHPMailer / VERIFICAÇÃO DE E-MAIL
1. Instale o Composer.
2. Abra o terminal na pasta SWtech e execute: composer install
3. Configure as variáveis de ambiente SWTECH_EMAIL e SWTECH_EMAIL_PASSWORD com seu Gmail e senha de aplicativo.
4. O arquivo config/smtp.php possui os dados de exemplo. Nunca coloque senha real no GitHub.
5. O cadastro envia um link de confirmação. A confirmação registra o e-mail, mas não bloqueia o login.

RECURSOS
- Carrinho com alteração de quantidade e remoção.
- Impede finalizar pedido com carrinho vazio.
- Pedidos e itens relacionados ao usuário.
- Histórico de pedidos.
- Pagamento exclusivamente simulado, sem cobrança.
- Cadastro de produtos com imagem JPG, PNG ou WEBP de até 3 MB.
- Logout que destrói a sessão.

TESTES MANUAIS PENDENTES NO XAMPP
- Criar conta com e-mail válido e confirmar o recebimento.
- Abrir o link e conferir email_verificado = 1.
- Entrar e sair e confirmar encerramento da sessão.
- Adicionar, alterar quantidade e remover produto.
- Tentar confirmar pedido com carrinho vazio.
- Registrar pedido e conferir vendas e itens_venda.
- Consultar histórico de pedidos.
- Cadastrar produto com imagem e conferir listagem e detalhes.
- Testar formato de imagem inválido e arquivo maior que 3 MB.

Observação: os testes acima precisam ser executados no XAMPP com o banco local e SMTP configurado.
