<h1 id="project-api">Project API</h1>
<p>REST API для управления проектами, на Laravel с использованием Docker.</p>
<hr>
<h2 id="описание">Описание</h2>
<p>Проект предоставляет:</p>
<ul>
<li>CRUD для проектов</li>
<li>Проверку доступности URL проектов с логированием времени ответа</li>
<li>Кастомную обработку ошибок через <code>Handler</code></li>
<li>Юнит и Feature тесты с моками HTTP</li>
<li>Полную работу через Docker</li>
</ul>
<hr>
<h2 id="структура-проекта">Структура проекта</h2>
<ul>
<li><code>app/Models/Project.php</code> модель проекта</li>
<li><code>app/Http/Controllers/ProjectController.php</code> контроллер API</li>
<li><code>app/Services/UrlCheckService.php</code> сервис проверки URL</li>
<li><code>app/Exceptions/Handler.php</code> кастомная обработка ошибок</li>
<li><code>tests/Feature</code> feature тесты</li>
<li><code>tests/Unit</code> юнит тесты</li>
<li><code>tests/Integration</code> Интеграционные тесты</li>
<li><code>docker-compose.yml</code> – конфигурация Docker</li>
</ul>
<hr>
<h2 id="установка-и-запуск-через-docker">Установка и запуск через Docker</h2>
<ol>
<li>Клонирование проекта:</li>
</ol>
<pre><code class="language-bash">git clone https://github.com/matvey192/LaravelProject.git
cd project-name
</code></pre>
<ol start="2">
<li>Копируем <code>.env</code>генерация ключа приложения:</li>
</ol>
<pre><code class="language-bash">cp .env.example .env
docker compose run --rm app php artisan key:generate
</code></pre>
<ol start="3">
<li>Сборка контейнера и запуск:</li>
</ol>
<pre><code class="language-bash">composer install
</code></pre>
<pre><code class="language-bash">docker compose up -d --build
</code></pre>
<ol start="4">
<li>Делаем миграции базы данных:</li>
</ol>
<pre><code class="language-bash">docker compose exec app php artisan migrate
</code></pre>
<ol start="5">
<li>Запускаем фабрики и заполняем бд</li>
</ol>
<pre><code class="language-bash">docker compose exec app php artisan db:seed
</code></pre>
<ol start="6">
<li>Сервер доступен по адресу:</li>
</ol>
<pre><code>http://localhost:8000/api/projects/
</code></pre>
<ol start="7">
<li>swagger доступен по адресу:</li>
</ol>
<pre><code>http://localhost:8000/swagger.html
</code></pre>
<hr>
<h2 id="endpoints-api">Endpoints API</h2>
<table>
<thead>
<tr>
<th>Метод</th>
<th>URL</th>
<th>Описание</th>
</tr>
</thead>
<tbody><tr>
<td>GET</td>
<td>/api/projects</td>
<td>Список проектов</td>
</tr>
<tr>
<td>GET</td>
<td>/api/projects/{id}</td>
<td>Просмотр проекта</td>
</tr>
<tr>
<td>POST</td>
<td>/api/projects</td>
<td>Создание проекта</td>
</tr>
<tr>
<td>PUT</td>
<td>/api/projects/{id}</td>
<td>Обновление проекта</td>
</tr>
<tr>
<td>DELETE</td>
<td>/api/projects/{id}</td>
<td>Удаление проекта</td>
</tr>
<tr>
<td>GET</td>
<td>/api/projects/{id}/check</td>
<td>Проверка доступности URL проекта</td>
</tr>
</tbody></table>
<h3 id="пример-ответа-apiprojectsidcheck">Пример ответа <code>/api/projects/{id}/check</code></h3>
<pre><code class="language-json">{
    &quot;status&quot;: &quot;available&quot;,
    &quot;http_code&quot;: 200,
    &quot;response_time_ms&quot;: 123,
    &quot;checked_at&quot;: &quot;2025-12-05T12:34:56Z&quot;
}
</code></pre>
<hr>
<h2 id="обработка-ошибок">Обработка ошибок</h2>
<ul>
<li><code>ModelNotFoundException</code> → JSON с кодом 404</li>
</ul>
<pre><code class="language-json">{
  &quot;success&quot;: false,
  &quot;code&quot;: 404,
  &quot;error&quot;: &quot;model_not_found&quot;,
  &quot;message&quot;: &quot;Project с id 1000 не найден&quot;,
  &quot;details&quot;: null
}
</code></pre>
<ul>
<li><code>ValidationException</code> → JSON с кодом 422</li>
<li><code>AccessDeniedHttpException</code> → JSON с кодом 403</li>
<li><code>RequestException</code> с таймаутом → JSON с кодом 504</li>
<li>Остальные ошибки → JSON с кодом 500 (с трассировкой в режиме debug)</li>
</ul>
<hr>
<h2 id="тестирование">Тестирование</h2>
<p>В проекте есть <strong>юнит и feature-тесты</strong>, включая мокинг HTTP-запросов для проверки доступности URL.</p>
<p>Запуск тестов через Docker:</p>
<pre><code class="language-bash">docker compose exec app php artisan test
</code></pre>
<hr>
