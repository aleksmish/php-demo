<form name="form_add" method="post">
    <div class="column">
        <div class="mb3">
            <label id="surname" class="form-label">Фамилия</label> <input type="text" id='surname' class="form-control" name="surname" placeholder="Фамилия" value="<?php echo $row['surname']?>">
        </div>
        <div class="mb3">
            <label id="name" class="form-label">Имя</label> <input id="name" type="text" class="form-control" name="name" placeholder="Имя" value="<?=$row['name'];?>">
        </div>
        <div class="mb3">
            <label id="lastname" class="form-label">Отчество</label> <input id="lastname" class="form-control" type="text" name="lastname" placeholder="Отчество" value="<?php echo $row['lastname']?>">
        </div>
        <div class="mb3">
            <label>Пол</label> 
            <select class="form-select"  name="gender">
                <option value='<?=$row['gender'];?>'><?=$row['gender'];?></option>
                <option value="мужской">мужской</option>
                <option value="женский">женский</option>
            </select>
        </div>
        <div class="mb3">
            <label class="form-label" id="date">Дата рождения</label> <input class="form-control" type="date" name="date" value="<?=$row['date'];?>">
        </div>
        <div class="mb3">
            <label class="form-label">Телефон</label> <input class="form-control" type="text" name="phone" placeholder="Телефон" value="<?=$row['phone'];?>">
        </div>
        <div class="mb3">
            <label class="form-label">Адрес</label> <input class="form-control" type="text" name="location" placeholder="Адрес" value="<?=$row['location'];?>"> 
        </div>
        <div class="mb3">
            <label class="form-label">Email</label> <input class="form-control" type="email" name="email" placeholder="Email" value="<?=$row['email'];?>">
        </div>
        <div class="mb3">
            <label class="form-label">Комментарий</label> <textarea name="comment" class="form-control" placeholder="Краткий комментарий"><?=$row['comment'];?></textarea>
        </div>
        <button class="btn btn-primary mt-2" type="submit" value="<?=$button;?>" name="button" class="form-btn"><?=$button;?></button>
    </div>
</form>