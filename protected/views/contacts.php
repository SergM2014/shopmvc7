<nav class="breadcrumbs">

    <a href="<?php echo URL; ?>">Головна</a> / <span>Контакты</span>

</nav>

<div class="the_content clearfix">
    <section class="wide_content">

        <div class="map invisible">
            <button id="writeUs">Напиши нам письмецо</button>
            <div id="map"><iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d164524.0836798843!2d31.088186765820314!3d49.88587031330192!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1suk!2sua!4v1447865358584" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe></div>
        </div>

        <div class="writeUsBlock">
            <form method="post">
                <label for="name">Имя</label>
               <p> <input type="text" name="name" id="name" placeholder="Введите Ваше Имя"></p>

                <label for="phone" >Телефон</label>
                <p><input type="text" name="phone" id="phone" placeholder="Введите Ваш телефон"></p>

                <label for="email">Email</label>
                <p><input type="text" name="email" id="email"></p>

                <label for="message">Ваше Сообщение</label>
                <p><textarea name="message" id="message" placeholder="Введите Ваше сообщение"></textarea></p>

                <p><img src="./?<?php echo session_name()?>=<?php echo session_id()?>"></p>
                <p><input type="text" name="keystring"></p>

            </form>
        </div>

    </section>
</div>