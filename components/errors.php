<?php
    /**
     * Класс служит для вывода ошибок пользователя. Например, при валидации вводимых данных
     */

    class Errors
    {
        /**
         * Метод для вывода ошибок
         * @param array $errors Массив с ошибками
         * @return string Конкретная ошибка
         */
        public function showErrors(array $errors)
        {
            foreach ($errors as $error) {
                return $error;
            }
        }

    }
