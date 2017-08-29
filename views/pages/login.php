<div id="login_page">
    <form id="login_form" action="" method="post" enctype="multipart/form-data">
        <div class="inner">
            <div>
                <label for="login_input">Введите ваш логин</label>
                <input name="login_form[user]" type="text" id="login_input">
                <span><?=$error_name?></span>
            </div>
            <div>
                <label for="login_pussword">Введите ваш пароль</label>
                <input name="login_form[password]" type="password" id="login_pussword">
                <span><?=$error_password?></span>
            </div>
            <div class="remember">
                <label for="remember">Запомнить меня</label>
                <input name="login_form[remember]" type="checkbox" id="remember">
            </div>
            <div class="form_submit">
                <button type="submit">Войти</button>
            </div>
        </div>
    </form>
</div>

