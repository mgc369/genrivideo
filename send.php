<?php
// Проверяем, что запрос был отправлен методом POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Собираем данные из формы
    $name = strip_tags(trim($_POST["Имя"]));
    $email = filter_var(trim($_POST["Email"]), FILTER_SANITIZE_EMAIL);
    $company = trim($_POST["Компания"]);
    $comment = trim($_POST["Комментарий"]);

    // Укажите ВАШУ почту, куда должны приходить заказы
    $recipient = "tynagual@gmail.com"; 

    // Тема письма
    $subject = "НОВЫЙ ЗАКАЗ С ЛЕНДИНГА GENRI: " . $name;

    // Формируем тело письма
    $email_content = "Имя: $name\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Компания: $company\n";
    $email_content .= "Комментарий:\n$comment\n";

    // Заголовки письма
    // ВАЖНО: замените "вашдомен.kz" на реальный домен сайта!
    $email_headers = "From: Заказ GenRI <no-reply@вашдомен.kz>\r\n";
    $email_headers .= "Reply-To: $email\r\n";
    $email_headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Отправляем письмо
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        // Успешная отправка: перенаправляем на страницу "Спасибо"
        http_response_code(200);
        header("Location: thank_you.html"); 
        exit; // !!! ГАРАНТИРУЕМ НЕМЕДЛЕННОЕ ПЕРЕНАПРАВЛЕНИЕ !!!
    } else {
        // Ошибка отправки
        http_response_code(500);
        echo "Ошибка: Не удалось отправить письмо.";
    }

} else {
    // Недопустимый метод запроса
    http_response_code(403);
    echo "Произошла ошибка с отправкой.";
}