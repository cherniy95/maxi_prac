<?php if ( isset($_POST['submit']) ): ?>
	<?php
		$connect->query("DROP TABLE IF EXISTS product, category, brands");

		$sql = "
			CREATE TABLE category (
			  id INT NOT NULL AUTO_INCREMENT,
			  name VARCHAR(45) NOT NULL,
			  PRIMARY KEY (id),
			  UNIQUE INDEX name_UNIQUE (name ASC))
			ENGINE = InnoDB
			";
		$connect->query($sql);

		$sql = "
			CREATE TABLE brands (
			  id INT NOT NULL AUTO_INCREMENT,
			  name VARCHAR(60) NOT NULL,
			  PRIMARY KEY (id),
			  UNIQUE INDEX name_UNIQUE (name ASC))
			ENGINE = InnoDB
			";
		$connect->query($sql);

		$sql = "
			CREATE TABLE product (
			  id INT NOT NULL AUTO_INCREMENT,
			  name VARCHAR(255) NOT NULL,
			  price FLOAT NOT NULL,
			  amount INT NOT NULL,
			  brand INT NOT NULL,
			  date DATE NOT NULL,
			  category INT NOT NULL,
			  image VARCHAR(255) NULL,
			  PRIMARY KEY (id),
			  INDEX _idx (category ASC),
			  INDEX brand_idx (brand ASC),
			  CONSTRAINT cat
			    FOREIGN KEY (category)
			    REFERENCES category (id)
			    ON DELETE NO ACTION
			    ON UPDATE NO ACTION,
			  CONSTRAINT brand
			    FOREIGN KEY (brand)
			    REFERENCES brands (id)
			    ON DELETE NO ACTION
			    ON UPDATE NO ACTION)
			ENGINE = InnoDB
			";
		$connect->query($sql);
		
		$file = fopen("db.csv", "r+");

		while( $row = fgetcsv($file) ) {
			$row[3] = $connect->real_escape_string($row[3]);
			$row[5] = $connect->real_escape_string($row[5]);

			$res = $connect->query("SELECT id FROM brands WHERE name = '$row[3]'");
			if ( $res->num_rows != 0 ) {
				$brand_id = $res->fetch_assoc()['id'];
			} else {
				$connect->query("INSERT INTO brands VALUES ('', '$row[3]')");
				$brand_id = $connect->insert_id;
			}

			$res = $connect->query("SELECT id FROM category WHERE name = '$row[5]'");
			if ( $res->num_rows != 0 ) {
				$category_id = $res->fetch_assoc()['id'];
			} else {
				$connect->query("INSERT INTO category VALUES ('', '$row[5]')");
				$category_id = $connect->insert_id;
			}

			$connect->query("
					INSERT INTO product VALUES (
						'',
						'$row[0]',
						$row[1],
						$row[2],
						$brand_id,
						'$row[4]',
						$category_id,
						'$row[6]'
					)
				");
		}

		echo "Успешно!";
	?>
<?php else: ?>
	<form action="" method="POST">
		<p>Выполнить инициализацию?</p>
		<input type="submit" name="submit" value="Да">
	</form>
<?php endif; ?>