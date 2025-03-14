-- Banco de dados de livraria
-- Este banco de dados será para gerenciar os livros

-- Criar banco de dados
CREATE DATABASE livraria;

-- Após criar o banco de dados, conecte-se a ele:
-- \c livraria;

-- Criar tabela de editoras
CREATE TABLE Editoras (
    ID_Editoras SERIAL PRIMARY KEY,
    Nome VARCHAR(255) NOT NULL,
    Endereco VARCHAR(255)
);

-- Criar tabela de categorias
CREATE TABLE Categorias (
    ID_Categoria SERIAL PRIMARY KEY,
    Nome VARCHAR(255) NOT NULL
);

-- Criar tabela de livros com as referências para editoras e categorias
CREATE TABLE Livros (
    ID_Livro SERIAL PRIMARY KEY,
    Titulo VARCHAR(255) NOT NULL,
    Autor VARCHAR(255) NOT NULL,
    ID_Editora INT REFERENCES Editoras(ID_Editoras),
    ID_Categoria INT REFERENCES Categorias(ID_Categoria)
);
-- Inserindo quatro livros fictícios
INSERT INTO Livros (Titulo, Autor, ID_Editora, ID_Categoria) VALUES
('As Aventuras de Matteo', 'Bebela', 1, 1),     -- Título com 'Matteo' como protagonista
('O Enigma da Floresta', 'Matthew', 1, 2),             -- Autor é 'Matthew' (escritor)
('O Mistério de Isabelle', 'Teteu', 2, 3),   -- Título com 'Isabelle' como protagonista
('Luzes do Destino', 'Isabela', 2, 4);              -- Autor é 'Isabela' (escritora)