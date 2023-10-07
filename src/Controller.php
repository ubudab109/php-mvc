<?php

namespace MVC;

class Controller 
{
    /**
     * The render function in PHP extracts data and includes a specified view file.
     * 
     * @param mixed $view The  parameter is the name of the view file that you want to render. It should
     * be a string that represents the file name without the file extension. For example, if you want
     * to render the "home.php" view file, you would pass "home" as the  parameter.
     * @param array $data The `` parameter is an optional array that contains the data that will be
     * passed to the view file. It allows you to pass variables from the controller to the view, so
     * that you can display dynamic content in your views.
     */
    protected function render($view, $data = [])
    {
        extract($data);
        include "Views/$view.php";
    }

    /**
     * The function responseJson is used to encode and output a JSON response with success status,
     * message, code, and data.
     * 
     * @param mixed $data The data parameter is used to pass any data that you want to include in the
     * JSON response. It can be any type of data, such as an array, object, string, or number.
     * @param mixed $message The message parameter is a mixed type variable that represents the message
     * to be included in the JSON response. It can be any type of data, such as a string or an array.
     * @param int $code The code parameter is an integer that represents the status code of the
     * response. It is typically used to indicate the success or failure of the request. For example, a
     * code of 200 typically indicates a successful request, while a code of 400 indicates a bad
     * request.
     * @param bool $success A boolean value indicating whether the response was successful or not.
     */
    protected function responseJson(mixed $data, mixed $message, int $code, bool $success)
    {
        echo json_encode([
            'success' => $success,
            'message' => $message,
            'code'    => $code,
            'data'    => $data,
        ]);
    }
}