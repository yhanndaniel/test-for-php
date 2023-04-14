# Autodoc\Test PHP

## Introdução

Bem-vindo ao teste para a vaga de desenvolvedor PHP :!

Neste teste, você será desafiado a finalizar a implementação de um cliente HTTP que está pela metade, 
adicionando métodos seguindo o verbo HTTP, como `GET`, `POST`, `PUT` e `DELETE`, e também criar um mecanismo 
de cache em arquivo e outro em memória usando uma mesma interface.

Para completar essa tarefa, você deve refatorar a classe `HttpResponse` para que a mesma utilize um mecanismo 
de cache nos métodos `GET`, `PUT` e `DELETE`. É importante notar que o cliente HTTP já possui um método `call` 
que já implementa toda a funcionalidade de requisição.

Além disso, o desenvolvedor deve criar uma interface para implementar um recurso de cache, e duas implementações 
diferentes usando a mesma interface, uma em memória e outra em arquivo.

## Observação
Importante ressaltar que não é permitido o uso de pacotes externos, apenas o phpunit pode ser utilizado para 
criar os testes de unidade.

Embora não seja obrigatório, fazer testes de unidade é altamente recomendado e pode render pontos extras.

Segue uma API Publica que pode ser utilizada no Cliente Http

https://jsonplaceholder.typicode.com/

## Uso

Para realizar o teste, siga os seguintes passos:

* Faça um fork do projeto no Github para a sua conta pessoal.
* Implemente os métodos GET, POST, PUT e DELETE na classe HttpResponse.
* Crie uma interface para implementar um recurso de cache, e duas implementações diferentes usando a mesma interface, uma em memória e outra em arquivo.
* Refatore a classe HttpResponse para que a mesma utilize um mecanismo de cache nos métodos GET, PUT e DELETE.
* Crie testes de unidade utilizando o phpunit.
* Nos avise por e-mail quando finalizar o teste. Não é necessário criar uma pull request.

Este teste foi projetado para avaliar suas habilidades em PHP, orientação a objetos, design patterns e boas práticas de programação. Boa sorte e divirta-se!
