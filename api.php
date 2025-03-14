<?php
header('Content-Type: application/json');

// Configurações de conexão com o banco de dados
$host = 'localhost';
$dbname = 'livraria';
$user = 'seu_usuario';      // substitua pelo seu usuário do banco de dados
$password = 'sua_senha';    // substitua pela sua senha
$dsn = "pgsql:host=$host;dbname=$dbname";

try {
    // Cria a conexão PDO com o modo de erros como exceção
    $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Erro na conexão com o banco de dados: " . $e->getMessage()]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    // Consulta para obter todos os livros
    $stmt = $pdo->query("SELECT * FROM Livros");
    $livros = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($livros);

} elseif ($method === 'POST') {
    // Recebe os dados do corpo da requisição
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['titulo']) || !isset($data['autor']) || !isset($data['id_editora']) || !isset($data['id_categoria'])) {
        http_response_code(400);
        echo json_encode(["error" => "Dados incompletos"]);
        exit;
    }

    $titulo = $data['titulo'];
    $autor = $data['autor'];
    $id_editora = (int)$data['id_editora'];
    $id_categoria = (int)$data['id_categoria'];

    // Prepara e executa a query de inserção usando um statement preparado para evitar SQL injection
    $stmt = $pdo->prepare("INSERT INTO Livros (titulo, autor, id_editora, id_categoria)
                           VALUES (:titulo, :autor, :id_editora, :id_categoria)
                           RETURNING *");
    $stmt->execute([
        ':titulo' => $titulo,
        ':autor' => $autor,
        ':id_editora' => $id_editora,
        ':id_categoria' => $id_categoria
    ]);

    // Obtém o registro inserido
    $novoLivro = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($novoLivro);

} else {
    http_response_code(405);
    echo json_encode(["error" => "Método não suportado"]);
}
?>