<!-- ATENÇÃO CSS'ers ADICIONAR CSS NESSA PÁGINA E NA PARTE DE EXIBIR COMENTÁRIOS EM "index.php"! -->

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Formulário de Feedback</title>
</head>
<body>
    <h1>Deixe seu Feedback</h1>
    
    <form id="feedbackForm">
        <textarea 
            id="comentario" 
            name="comentario" 
            placeholder="Digite seu comentário (máximo 300 caracteres)" 
            maxlength="300"
            rows="5"
            cols="50"
            required
        ></textarea>
        
        <div>
            <span id="contador">0</span>/300 caracteres
        </div>
        
        <br>
        <button type="submit">Enviar Feedback</button>
    </form>

    <div id="mensagem"></div>

    <script>
        // Contador de caracteres
        const textarea = document.getElementById('comentario');
        const contador = document.getElementById('contador');
        
        textarea.addEventListener('input', function() {
            contador.textContent = this.value.length;
        });

        // Envio do formulário com AJAX
        document.getElementById('feedbackForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('salvar_feedback.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const mensagem = document.getElementById('mensagem');
                if (data.success) {
                    mensagem.innerHTML = '<p style="color: green;">Feedback enviado com sucesso!</p>';
                    document.getElementById('feedbackForm').reset();
                    contador.textContent = '0';
                } else {
                    mensagem.innerHTML = '<p style="color: red;">Erro ao enviar feedback: ' + data.error + '</p>';
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                document.getElementById('mensagem').innerHTML = '<p style="color: red;">Erro ao enviar feedback.</p>';
            });
        });
    </script>
</body>
</html>