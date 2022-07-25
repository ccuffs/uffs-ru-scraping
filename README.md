<p align="center">
    <img width="800" src=".github/logo.png" title="Logo do projeto"><br />
    <img src="https://img.shields.io/maintenance/yes/2022?style=for-the-badge" title="Status do projeto">
    <img src="https://img.shields.io/github/workflow/status/ccuffs/template/ci.uffs.cc?label=Build&logo=github&logoColor=white&style=for-the-badge" title="Status do build">
</p>

# uffs-ru-scraping

Um pacote PHP para raspagem dos cardápios dos Restaurantes Universitários da [Universidade Federal da Fronteira Sul](https://www.uffs.edu.br/). A ideia desse pacote é permitir que APIs sejam criadas com informações sobre o cardápio dos RUs dos campi.

**IMPORTANTE:** coloque aqui alguma mensagem que é muito relevante aos usuários do projeto, se for o caso.

## ✨ Features

* Obtenção automática de informações dos cardápios através da [listagem no site da UFFS](https://www.uffs.edu.br/campi/chapeco/restaurante_universitario);
* Obtem os cardápios publicados no site pela data. ex: `18/07/2022`;
* Obtem cardápios publicados pelo dia da semana. ex: `segunda`;
* Dados estruturados para facilitar a manipulação.

## 🚀 Começando

### 1. Adicione o pacote ao seu projet

Na pasta raiz do seu projeto PHP, rode:Geralmente o primeiro passo para começar é instalar dependências para rodar o projeto. Rode:

```
composer require ccuffs/uffs-ru-scraping
```

Todas as dependências serão instaladas.

### 2. Obtenção dos Cardápios

Para obtem qualquer cardápio do RU, você utilizará a classe `UniversityRestaurantUFFS`. Um objeto dessa classe possui diversos métodos para obtenção de cardápios.

O mais simples é a obtenção de todos os cardápios disponíveis no site através do link ou nome do campus:

```
$ur = new \CCUFFS\Scrap\UniversityRestaurantUFFS();
$menu = $ur->getMenuByCampus("https://www.uffs.edu.br/campi/chapeco/restaurante_universitario");

//ou

$menu = $ur->getMenuByCampus($ur->campus["chapeco"]));
```

Nesse caso, `$menu` será um vetor de chave/objeto onde a chave será a data no formato `d/m/Y` e o objeto será um vetor com os elementos que compõe o cardápio no dia específico:

```
Array
(
    [18/07/2022] => Array
        (
            [0] => Alface

            [1] => Repolho branco

            [2] => Cenoura cozida

            [3] => Arroz branco

            [4] => Arroz integral

            [5] => Feijão-preto

            [6] => Farofa de cenoura c/ batata palha

            [7] => Cubos suínos assado c/ legumes

            [8] => PTS refogada

            [9] => Fruta
        )
...

    [15/07/2022] => Array
        (
            [0] => Alface

            [1] => Acelga 

            [2] => Beterraba

            [3] => Arroz branco

            [4] => Arroz integral

            [5] => Feijão preto 

            [6] => Macarrão c/ tomate e manjericão (contém glúten)

            [7] => Cubos bovinos ao molho 

            [8] => PTS à chinesa

            [9] => Pudim de baunilha (contém lactose)
        )
)

```

### 2. Obtenção de Cardápio por dia ou dia da semana

Se você deseja obter o cardápio de um dia específico, basta utilizar o método `getMenuByDate` usando o link do cardápio e a data no formato `d/m/Y` como parâmetros:
```
$ur = new UniversityRestaurantUFFS();
$menu = $ur->getMenuByDate($ur->campus["chapeco"], '25/07/2022');
```
ou utilizando o método `getMenuByWeekDay` usando o link do cardápio e o dia da semana nos formatos `seg`, `ter`, `qua`, `qui`, `sex` como parâmetros:
```
$ur = new UniversityRestaurantUFFS();
$menu = $ur->getMenuByWeekDay($ur->campus["chapeco"], 'seg');
```

Nesses dois métodos, se não é encontrado o valor do dia especificado, ele retornará `NULL`.

O resultado desses métodos será semelhante à esse:

```
Array
(
    [0] => Alface
    [1] => Beterraba
    [2] => Abobrinha
    [3] => Arroz branco
    [4] => Arroz integral
    [5] => Feijão-preto
    [6] => Batata palha
    [7] => Estrogonoffe bovino (contém lactose)
    [8] => Estrogonoffe de grão-de-bico (contém lactose)
    [9] => Fruta
)
```

## 👩‍💻 Desenvolvimento

Se você pretende criar features novas, corrigir bugs ou afins, siga o passo a passo abaixo.

Clone o repositório:

```
git clone https://github.com/ccuffs/uffs-ru-scraping && cd uffs-ru-scraping
```

Instale as dependências:

```
composer install
```

Implemente o que for necessário e faça seus testes através do [test.php](tests/test.php):

```
php tests/test.php
```

## 🤝 Contribua

Sua ajuda é muito bem-vinda, independente da forma! Confira o arquivo [CONTRIBUTING.md](CONTRIBUTING.md) para conhecer todas as formas de contribuir com o projeto. Por exemplo, [sugerir uma nova funcionalidade](https://github.com/ccuffs/template/issues/new?assignees=&labels=&template=feature_request.md&title=), [reportar um problema/bug](https://github.com/ccuffs/template/issues/new?assignees=&labels=bug&template=bug_report.md&title=), [enviar um pull request](https://github.com/ccuffs/hacktoberfest/blob/master/docs/tutorial-pull-request.md), ou simplemente utilizar o projeto e comentar sua experiência.

## 🎫 Licença

Esse projeto é licenciado nos termos da licença open-source [MIT](https://choosealicense.com/licenses/mit) e está disponível de graça.

## 🧬 Changelog

Veja todas as alterações desse projeto no arquivo [CHANGELOG.md](CHANGELOG.md).

## 🧪 Projetos semelhates

* Abaixo está uma lista de links interessantes e projetos similares:

* [uffs-sga-scraping](https://github.com/ccuffs/uffs-sga-scraping)
* [auth-iduffs](https://github.com/ccuffs/auth-iduffs)
* [uffs-ca-scraping](https://github.com/ccuffs/uffs-ca-scraping)
