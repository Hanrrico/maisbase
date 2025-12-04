
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Produtos</title>
    <link rel="stylesheet" href="../css/adminprod.css">
</head>
<body>

<!-- Menu -->
<nav class="navbar">
    <a href="telaadmin.php" class="navbar-brand">Ary Bordados</a>
    <ul>
        <li><a href="telaadmin.php">Voltar</a></li>
        <li><a href="index.php">Ver Catálogo</a></li>
        <li><a href="../control/logout_controller.php">Sair</a></li>
    </ul>
</nav>

<div class="container">
    <h2>Gerenciamento de Produtos</h2>
    
    <div class="tab-navigation">
        <button class="tab-button active" onclick="openTab('cadastro')">Cadastrar Produto</button>
        <button class="tab-button" onclick="openTab('lista')">Lista de Produtos</button>
    </div>

    <!-- Mensagens de alerta -->
    <div id="alertBox" class="alert"></div>

    <!-- Aba de Cadastro -->
    <div id="cadastro" class="tab-content active">
        <form id="productForm" enctype="multipart/form-data">
            <input type="hidden" id="productId" name="productId" value="">
            
            <div class="form-group">
                <label for="nome">Nome do produto:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            
            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="preco">Preço (R$):</label>
                <input type="number" id="preco" name="preco" step="0.01" min="0" required>
            </div>
            
            <div class="form-group">
                <label for="estoque">Estoque:</label>
                <input type="number" id="estoque" name="estoque" min="0" required>
            </div>
            
            <div class="form-group">
                <label for="categoria">Categoria:</label>
                <select id="categoria" name="categoria" required>
                    <option value="">Selecione...</option>
                    <option value="bordados">Bordados</option>
                    <option value="costura">Costura Criativa</option>
                    <option value="personalizados">Personalizados</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="imagem">Imagem do produto:</label>
                <input type="file" id="imagem" name="imagem" accept="image/*">
                <img id="preview" class="preview-image" src="" alt="Preview">
            </div>
            
            <div class="actions">
                <button type="submit" id="btnSalvar">Cadastrar Produto</button>
                <button type="button" id="btnCancelar" class="btn-secondary" style="display:none;">Cancelar</button>
            </div>
        </form>
    </div>

    <!-- Aba de Lista -->
    <div id="lista" class="tab-content">
        <table id="productsTable">
            <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Estoque</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <!-- Os produtos serão carregados aqui via JavaScript -->
            </tbody>
        </table>
    </div>
</div>

<script>
// Funções JavaScript para manipulação do CRUD
function openTab(tabName) {
    // Esconde todos os conteúdos de abas
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.remove('active');
    });
    
    // Mostra a aba selecionada
    document.getElementById(tabName).classList.add('active');
    
    // Atualiza os botões de aba
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active');
    });
    
    // Encontrar o botão que foi clicado e adicionar a classe active
    var buttons = document.querySelectorAll('.tab-button');
    for (var i = 0; i < buttons.length; i++) {
        if (buttons[i].getAttribute('onclick').includes(tabName)) {
            buttons[i].classList.add('active');
        }
    }
    
    // Se for a aba de lista, carrega os produtos
    if (tabName === 'lista') {
        loadProducts();
    }
}

// Função para carregar os produtos na tabela
function loadProducts() {
    console.log('Iniciando loadProducts...');
    
    fetch('../control/listar_produtos.php')
        .then(response => {
            console.log('Resposta recebida:', response);
            if (!response.ok) {
                throw new Error('Erro HTTP: ' + response.status);
            }
            return response.json();
        })
        .then(products => {
            console.log('Produtos recebidos:', products);
            const tbody = document.querySelector('#productsTable tbody');
            tbody.innerHTML = '';
            
            if (products.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" style="text-align: center;">Nenhum produto cadastrado</td></tr>';
                return;
            }
            
            products.forEach(product => {
                console.log('Processando produto:', product);
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>
                        ${product.imagem ? 
                            `<img src="${product.imagem}" class="product-image" alt="${product.nome}" onerror="this.src='https://via.placeholder.com/60'">` : 
                            '<span>Sem imagem</span>'
                        }
                    </td>
                    <td>${product.nome || 'N/A'}</td>
                    <td>R$ ${product.preco ? parseFloat(product.preco).toFixed(2) : '0.00'}</td>
                    <td>${product.estoque || 0}</td>
                    <td class="action-buttons">
                        <button onclick="editProduct(${product.id_produto})">Editar</button>
                        <button class="btn-danger" onclick="deleteProduct(${product.id_produto})">Excluir</button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        })
        .catch(error => {
            console.error('Erro ao carregar produtos:', error);
            const tbody = document.querySelector('#productsTable tbody');
            tbody.innerHTML = '<tr><td colspan="5" style="text-align: center; color: red;">Erro ao carregar produtos: ' + error.message + '</td></tr>';
        });
}

// Função para editar produto - CORRIGIDA
function editProduct(id) {
    console.log('Editando produto ID:', id);
    
    fetch('../control/listar_produtos.php')  // CORREÇÃO: adicionei ../control/
        .then(response => {
            console.log('Resposta da listagem:', response);
            return response.json();
        })
        .then(products => {
            console.log('Produtos recebidos para edição:', products);
            const product = products.find(p => p.id_produto == id);
            if (product) {
                console.log('Produto encontrado:', product);
                
                // Preenche o formulário com os dados do produto
                document.getElementById('productId').value = product.id_produto;
                document.getElementById('nome').value = product.nome;
                document.getElementById('descricao').value = product.descricao;
                document.getElementById('preco').value = product.preco;
                document.getElementById('estoque').value = product.estoque;
                document.getElementById('categoria').value = product.categoria;
                
                if (product.imagem) {
                    document.getElementById('preview').src = product.imagem;
                    document.getElementById('preview').style.display = 'block';
                } else {
                    document.getElementById('preview').style.display = 'none';
                }
                
                // Altera o texto do botão para "Atualizar"
                document.getElementById('btnSalvar').textContent = 'Atualizar Produto';
                document.getElementById('btnCancelar').style.display = 'inline-block';
                
                // Muda para a aba de cadastro
                openTab('cadastro');
            } else {
                console.log('Produto não encontrado para o ID:', id);
                alert('Produto não encontrado!');
            }
        })
        .catch(error => {
            console.error('Erro ao carregar produto para edição:', error);
            alert('Erro ao carregar dados do produto.');
        });
}

// Submit do formulário - 
document.getElementById('productForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const productId = document.getElementById('productId').value;

    console.log('Enviando formulário, productId:', productId);

    let url = '../control/cadastrar_action.php'; 
    if (productId) {
        url = '../control/editar_produto.php';   
        formData.append('id', productId);
        console.log('Modo edição, URL:', url);
    } else {
        console.log('Modo cadastro, URL:', url);
    }

    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then(response => {
        console.log('Resposta do servidor:', response);
        return response.json();
    })
    .then(data => {
        console.log('Dados da resposta:', data);
        if (data.success) {
            alert(data.message);
            resetForm();
            if (productId) {
                // Se estava editando, voltar para a lista
                openTab('lista');
            }
        } else {
            alert('Erro: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Erro completo ao salvar produto:', error);
        alert('Erro ao salvar produto. Verifique o console para detalhes.');
    });
});

// Função para cancelar edição
document.getElementById('btnCancelar').addEventListener('click', function() {
    resetForm();
});

// Função para resetar o formulário
function resetForm() {
    document.getElementById('productForm').reset();
    document.getElementById('preview').style.display = 'none';
    document.getElementById('productId').value = '';
    document.getElementById('btnSalvar').textContent = 'Cadastrar Produto';
    document.getElementById('btnCancelar').style.display = 'none';
}

// Função para excluir produto
function deleteProduct(id) {
    if (confirm('Tem certeza que deseja excluir este produto?')) {
        const formData = new FormData();
        formData.append('id', id);

        fetch('../control/excluir_produto.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                loadProducts();
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Erro ao excluir produto:', error);
        });
    }
}

// Preview da imagem
document.getElementById('imagem').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            document.getElementById('preview').src = event.target.result;
            document.getElementById('preview').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});

// Submit do formulário
document.getElementById('productForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const productId = document.getElementById('productId').value;

    let url = 'cadastrar_action.php';
    if (productId) {
        url = 'editar_produto.php';
        formData.append('id', productId);
    }

    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            resetForm();
            if (productId) {
                // Se estava editando, voltar para a lista
                openTab('lista');
            }
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Erro ao salvar produto:', error);
    });
});

// Inicializar a aba ativa
openTab('cadastro');
</script>


</body>
</html>