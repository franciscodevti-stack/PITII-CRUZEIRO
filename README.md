# Projeto Fullstack: Projeto integrador transdiciplinar 2

Este projeto tem como objetivo desenvolver um site de vendas de Cupcakes

## Como rodar o projeto *local*?

### 1. **Clone o repositório:**
~~~sh
git clone https://github.com/franciscodevti-stack/PITII-CRUZEIRO.git
~~~

### 2. **Baixe e instale o Xampp e crie o banco de dados no MySQL**

Se você tiver dificuldades para instalar e configurar o Xampp e criar o banco no MySQL, siga este passo a passo neste [vídeo](https://www.youtube.com/watch?v=y-EAlMQs29E).


#### **Passos para criar o banco e configurar o projeto:**

1. **Abra o Xampp**
  - Certifique-se que os módulos do Apache e MySQL estejam rodando corretamente.

2. **Utilize o script SQL do repositório para gerar as tabelas e o usuário padrão**
  - Clique no menu Admin do MySQL no Xamp para abrir a página,
  - No menu superior, clique em **Importar > Procurar...** e selecione o script SQL disponível no repositório.

3. **Carregue o script no MySQL**:
  - Com o script carregado, revise as instruções SQL para garantir que tudo está correto.

4. **Importe o script**:
  - Clique no botão **Importar** para rodar o script e criar as tabelas e o usuário padrão.

5. **Verifique o usuário admin**:
   - Agora, você deve ter um **usuário admin** registrado na tabela, pronto para ser utilizado nos testes e na aplicação.

---

> **Dica:** Verifique se as configurações para se conectar ao MySQL estão corretas. Por padrão, o host, port e user são definidos como abaixo, mas ajuste conforme necessário para sua conexão.

PORT=3000  
MY_SQL_HOST="localhost"  
MY_SQL_PORT="3306"  
MY_SQL_USER="root"  
MY_SQL_PASSWORD=""  
MY_SQL_DATABASE="cupcake_db"

Seguindo esses passos, você terá o banco de dados configurado e pronto para uso com o projeto clicando no menu Admin do Apache no Xampp.

Verifique se tudo está funcionando corretamente acessando a seguinte URL no navegador:

<http://localhost/site-cupcake/>

### Informações Adicionais

- **Link da Solução em Funcionamento:** [cupcake-site](https://mundodocupcake.ct.ws/)
- **Usuário DEMO ADMIN**: `admin` / `admin`
- **Linguagem Back-end**: PHP + Javascript
- **Banco de Dados**: Mysql
- **Hospedagem**: https://www.infinityfree.com/
- **Plataforma**: Web (responsivo para tablet, smartphone e web)

## Utils

- **História de usuários**: [histórias](./documentacoes/historia_de_usuario.pdf)
- **Diagrama de banco de dados**: [imagem](./documentacoes/diagrama_de_banco_de_dados.jpg)
- **Diagrama de implantação**: [imagem](./documentacoes/diagrama_de_implantacao.jpg)
- **Diagrama de caso de uso**: [imagem](./documentacoes/caso_de_uso.jpg)

- ## Imagens

- **Loja:**:
- ![Loja](./documentacoes/loja.jpg)

- - **Painel de Admin:**
- ![Painel de Admin](./documentacoes/admin.jpg)
