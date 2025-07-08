<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Libro;

class LibroSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener todas las categorías y autores
        $categorias = \App\Models\Categoria::all()->keyBy('nombre');
        $autores = \App\Models\Autor::all()->keyBy('nombre');

        // NOVELA - Gabriel García Márquez, Isabel Allende, George Orwell
        $this->crearLibrosCategoria('Novela', [
            ['Gabriel García Márquez', 'Cien años de soledad', 'Novela emblemática del realismo mágico', 49.90, 'libros/cien-anos-soledad.jpg', 'Español', 4.8, '1967-05-30'],
            ['Gabriel García Márquez', 'El amor en los tiempos del cólera', 'Historia de amor en el Caribe', 44.90, 'libros/el-amor-en-los-tiempos-del-colera.jpg', 'Español', 4.7, '1985-09-05'],
            ['Gabriel García Márquez', 'One Hundred Years of Solitude', 'English edition of magical realism', 52.00, 'libros/one-hundred-years-of-solitude.jpg', 'Inglés', 4.9, '1970-01-01'],
            ['Isabel Allende', 'La casa de los espíritus', 'Saga familiar con realismo mágico', 42.90, 'libros/la-casa-de-los-espiritus.jpg', 'Español', 4.5, '1982-01-01'],
            ['Isabel Allende', 'Eva Luna', 'Historia extraordinaria en América Latina', 38.50, 'libros/eva-luna.jpg', 'Español', 4.4, '1987-01-01'],
            ['Isabel Allende', 'The House of the Spirits', 'English edition of magical realist saga', 45.00, 'libros/the-house-of-the-spirits.jpg', 'Inglés', 4.6, '1985-01-01'],
            ['George Orwell', '1984', 'Novela distópica sobre totalitarismo', 39.90, 'libros/1984.jpg', 'Español', 4.9, '1949-06-08'],
            ['George Orwell', 'Rebelión en la granja', 'Alegoría política sobre revolución', 29.90, 'libros/rebelion-en-la-granja.jpg', 'Español', 4.8, '1945-08-17'],
            ['George Orwell', 'Animal Farm', 'English edition of political allegory', 32.00, 'libros/animal-farm.jpg', 'Inglés', 4.9, '1945-08-17'],
        ], $categorias, $autores);

        // FANTASÍA - J.K. Rowling, J.R.R. Tolkien, Patrick Rothfuss
        $this->crearLibrosCategoria('Fantasía', [
            ['J.K. Rowling', 'Harry Potter y la piedra filosofal', 'El inicio de la saga de Harry Potter', 45.00, 'libros/harry-potter-1.jpg', 'Español', 4.9, '1997-06-26'],
            ['J.K. Rowling', 'Harry Potter y la cámara secreta', 'Harry regresa a Hogwarts', 46.00, 'libros/harry-potter-2.jpg', 'Español', 4.8, '1998-07-02'],
            ['J.K. Rowling', 'Harry Potter and the Prisoner of Azkaban', 'English edition of Harry Potter', 48.00, 'libros/harry-potter-3.jpg', 'Inglés', 4.9, '1999-07-08'],
            ['J.R.R. Tolkien', 'El Hobbit', 'Aventura de Bilbo Bolsón', 50.00, 'libros/el-hobbit.jpg', 'Español', 4.8, '1937-09-21'],
            ['J.R.R. Tolkien', 'El Señor de los Anillos: La Comunidad', 'Épica travesía de Frodo', 55.00, 'libros/el-senor-de-los-anillos-1.jpg', 'Español', 4.9, '1954-07-29'],
            ['J.R.R. Tolkien', 'The Lord of the Rings', 'English edition of the epic', 58.00, 'libros/the-lord-of-the-rings.jpg', 'Inglés', 4.9, '1954-07-29'],
            ['Patrick Rothfuss', 'El nombre del viento', 'Historia de Kvothe el Arcano', 52.00, 'libros/el-nombre-del-viento.jpg', 'Español', 4.7, '2007-03-27'],
            ['Patrick Rothfuss', 'El temor de un hombre sabio', 'Segunda parte de la saga', 54.00, 'libros/el-temor-de-un-hombre-sabio.jpg', 'Español', 4.6, '2011-03-01'],
            ['Patrick Rothfuss', 'The Name of the Wind', 'English edition of Kvothe story', 56.00, 'libros/the-name-of-the-wind.jpg', 'Inglés', 4.8, '2007-03-27'],
        ], $categorias, $autores);

        // CIENCIA FICCIÓN - Isaac Asimov, Philip K. Dick, Arthur C. Clarke
        $this->crearLibrosCategoria('Ciencia Ficción', [
            ['Isaac Asimov', 'Fundación', 'Saga sobre imperio galáctico', 42.00, 'libros/fundacion.jpg', 'Español', 4.8, '1951-06-01'],
            ['Isaac Asimov', 'Yo, Robot', 'Relatos sobre robots', 38.00, 'libros/yo-robot.jpg', 'Español', 4.7, '1950-12-02'],
            ['Isaac Asimov', 'Foundation', 'English edition of galactic empire', 45.00, 'libros/foundation.jpg', 'Inglés', 4.9, '1951-06-01'],
            ['Philip K. Dick', '¿Sueñan los androides con ovejas?', 'Novela que inspiró Blade Runner', 37.00, 'libros/suenan-los-androides.jpg', 'Español', 4.7, '1968-03-01'],
            ['Philip K. Dick', 'El hombre en el castillo', 'Historia alternativa WWII', 39.00, 'libros/el-hombre-en-el-castillo.jpg', 'Español', 4.5, '1962-10-01'],
            ['Philip K. Dick', 'Do Androids Dream of Electric Sheep?', 'English edition of Blade Runner', 42.00, 'libros/do-androids-dream.jpg', 'Inglés', 4.8, '1968-03-01'],
            ['Arthur C. Clarke', '2001: Una odisea espacial', 'Novela que inspiró Kubrick', 48.00, 'libros/2001-odisea-espacial.jpg', 'Español', 4.9, '1968-07-01'],
            ['Arthur C. Clarke', 'Cita con Rama', 'Humanidad explora nave alienígena', 46.00, 'libros/cita-con-rama.jpg', 'Español', 4.7, '1973-12-01'],
            ['Arthur C. Clarke', '2001: A Space Odyssey', 'English edition of space epic', 50.00, 'libros/2001-a-space-odyssey.jpg', 'Inglés', 4.8, '1968-07-01'],
        ], $categorias, $autores);

        // MISTERIO - Agatha Christie, Arthur Conan Doyle, Patricia Highsmith
        $this->crearLibrosCategoria('Misterio', [
            ['Agatha Christie', 'Asesinato en el Orient Express', 'Poirot investiga en el tren', 48.90, 'libros/asesinato-en-el-orient-express.jpg', 'Español', 4.7, '1934-01-01'],
            ['Agatha Christie', 'Diez Negritos', 'Misterio en isla remota', 45.50, 'libros/diez-negritos.jpg', 'Español', 4.8, '1939-11-06'],
            ['Agatha Christie', 'Murder on the Orient Express', 'English edition of Poirot mystery', 52.00, 'libros/murder-on-the-orient-express.jpg', 'Inglés', 4.9, '1934-01-01'],
            ['Arthur Conan Doyle', 'El Perro de los Baskerville', 'Sherlock Holmes investiga', 42.90, 'libros/el-perro-de-los-baskerville.jpg', 'Español', 4.6, '1902-04-01'],
            ['Arthur Conan Doyle', 'Estudio en Escarlata', 'Primera novela de Holmes', 39.50, 'libros/estudio-en-escarlata.jpg', 'Español', 4.5, '1887-12-01'],
            ['Arthur Conan Doyle', 'The Hound of the Baskervilles', 'English edition of Holmes', 46.00, 'libros/the-hound-of-the-baskervilles.jpg', 'Inglés', 4.7, '1902-04-01'],
            ['Patricia Highsmith', 'Extraños en un Tren', 'Intercambio de asesinatos', 44.90, 'libros/extraños-en-un-tren.jpg', 'Español', 4.4, '1950-01-01'],
            ['Patricia Highsmith', 'El Talento de Mr. Ripley', 'Tom Ripley asume identidad', 47.50, 'libros/el-talento-de-mr-ripley.jpg', 'Español', 4.6, '1955-01-01'],
            ['Patricia Highsmith', 'Strangers on a Train', 'English edition of thriller', 50.00, 'libros/strangers-on-a-train.jpg', 'Inglés', 4.5, '1950-01-01'],
        ], $categorias, $autores);

        // ROMANCE - Jane Austen, Nicholas Sparks, Federico Moccia
        $this->crearLibrosCategoria('Romance', [
            ['Jane Austen', 'Orgullo y Prejuicio', 'Historia de Elizabeth y Darcy', 45.90, 'libros/orgullo-y-prejuicio.jpg', 'Español', 4.8, '1813-01-28'],
            ['Jane Austen', 'Emma', 'Emma Woodhouse como casamentera', 42.50, 'libros/emma.jpg', 'Español', 4.6, '1815-12-23'],
            ['Jane Austen', 'Pride and Prejudice', 'English edition of classic romance', 48.00, 'libros/pride-and-prejudice.jpg', 'Inglés', 4.9, '1813-01-28'],
            ['Nicholas Sparks', 'El Diario de Noah', 'Historia de amor eterno', 52.90, 'libros/el-diario-de-noah.jpg', 'Español', 4.5, '1996-10-01'],
            ['Nicholas Sparks', 'Un Paseo para Recordar', 'Landon y Jamie en Carolina', 49.50, 'libros/un-paseo-para-recordar.jpg', 'Español', 4.4, '1999-10-01'],
            ['Nicholas Sparks', 'The Notebook', 'English edition of love story', 55.00, 'libros/the-notebook.jpg', 'Inglés', 4.6, '1996-10-01'],
            ['Federico Moccia', 'Tres Metros Sobre el Cielo', 'Babi y Step en Roma', 38.90, 'libros/tres-metros-sobre-el-cielo.jpg', 'Español', 4.3, '1992-01-01'],
            ['Federico Moccia', 'Tengo Ganas de Ti', 'Secuela de Tres Metros', 41.00, 'libros/tengo-ganas-de-ti.jpg', 'Español', 4.2, '2006-01-01'],
            ['Federico Moccia', 'Perdona si te llamo amor', 'Niki y Alessandro', 39.50, 'libros/perdona-si-te-llamo-amor.jpg', 'Español', 4.1, '2007-01-01'],
        ], $categorias, $autores);

        // HISTORIA - Yuval Noah Harari, Mary Beard, Simon Sebag Montefiore
        $this->crearLibrosCategoria('Historia', [
            ['Yuval Noah Harari', 'Sapiens: De Animales a Dioses', 'Historia de la humanidad', 65.90, 'libros/sapiens-de-animales-a-dioses.jpg', 'Español', 4.8, '2011-01-01'],
            ['Yuval Noah Harari', 'Homo Deus: Breve Historia del Mañana', 'Futuro de la humanidad', 68.50, 'libros/homo-deus-breve-historia-del-manana.jpg', 'Español', 4.6, '2015-01-01'],
            ['Yuval Noah Harari', 'Sapiens: A Brief History of Humankind', 'English edition of human history', 72.00, 'libros/sapiens-a-brief-history-of-humankind.jpg', 'Inglés', 4.9, '2011-01-01'],
            ['Mary Beard', 'SPQR: Una Historia de la Antigua Roma', 'Nueva historia de Roma', 62.90, 'libros/spqr-una-historia-de-la-antigua-roma.jpg', 'Español', 4.7, '2015-11-03'],
            ['Mary Beard', 'Pompeya: La Vida de una Ciudad Romana', 'Vida en Pompeya', 58.50, 'libros/pompeya-la-vida-de-una-ciudad-romana.jpg', 'Español', 4.5, '2008-01-01'],
            ['Mary Beard', 'SPQR: A History of Ancient Rome', 'English edition of Roman history', 66.00, 'libros/spqr-a-history-of-ancient-rome.jpg', 'Inglés', 4.8, '2015-11-03'],
            ['Simon Sebag Montefiore', 'Jerusalén: La Biografía', 'Historia de Jerusalén', 69.90, 'libros/jerusalen-la-biografia.jpg', 'Español', 4.6, '2011-01-27'],
            ['Simon Sebag Montefiore', 'Los Romanov: 1613-1918', 'Historia de los Romanov', 71.50, 'libros/los-romanov-1613-1918.jpg', 'Español', 4.7, '2016-05-26'],
            ['Simon Sebag Montefiore', 'Jerusalem: The Biography', 'English edition of Jerusalem', 74.00, 'libros/jerusalem-the-biography.jpg', 'Inglés', 4.8, '2011-01-27'],
        ], $categorias, $autores);

        // BIOGRAFÍA - Walter Isaacson, Michelle Obama, Andrew Morton
        $this->crearLibrosCategoria('Biografía', [
            ['Walter Isaacson', 'Steve Jobs: La Biografía', 'Biografía del fundador de Apple', 72.90, 'libros/steve-jobs-la-biografia.jpg', 'Español', 4.8, '2011-10-24'],
            ['Walter Isaacson', 'Leonardo da Vinci: La Biografía', 'Biografía del genio renacentista', 75.50, 'libros/leonardo-da-vinci-la-biografia.jpg', 'Español', 4.7, '2017-10-17'],
            ['Walter Isaacson', 'Steve Jobs: The Biography', 'English edition of Jobs biography', 78.00, 'libros/steve-jobs-the-biography.jpg', 'Inglés', 4.9, '2011-10-24'],
            ['Michelle Obama', 'Mi Historia', 'Memorias de Michelle Obama', 68.90, 'libros/mi-historia-michelle-obama.jpg', 'Español', 4.6, '2018-11-13'],
            ['Michelle Obama', 'Becoming: Mi Historia', 'Versión en español', 65.50, 'libros/becoming-mi-historia.jpg', 'Español', 4.5, '2018-11-13'],
            ['Michelle Obama', 'Becoming', 'English edition of Obama memoir', 70.00, 'libros/becoming.jpg', 'Inglés', 4.7, '2018-11-13'],
            ['Andrew Morton', 'Diana: Su Verdadera Historia', 'Biografía de la Princesa Diana', 58.90, 'libros/diana-su-verdadera-historia.jpg', 'Español', 4.4, '1992-07-01'],
            ['Andrew Morton', 'Meghan: Una Princesa de Hollywood', 'Biografía de Meghan Markle', 55.50, 'libros/meghan-una-princesa-de-hollywood.jpg', 'Español', 4.2, '2018-04-17'],
            ['Andrew Morton', 'Diana: Her True Story', 'English edition of Diana biography', 62.00, 'libros/diana-her-true-story.jpg', 'Inglés', 4.5, '1992-07-01'],
        ], $categorias, $autores);

        // AUTOAYUDA - Stephen R. Covey, Dale Carnegie, Louise L. Hay
        $this->crearLibrosCategoria('Autoayuda', [
            ['Stephen R. Covey', 'Los 7 Hábitos de la Gente Altamente Efectiva', 'Enfoque holístico para resolver problemas', 58.90, 'libros/los-7-habitos-de-la-gente-altamente-efectiva.jpg', 'Español', 4.7, '1989-08-15'],
            ['Stephen R. Covey', 'Primero lo Primero', 'Guía para establecer prioridades', 52.50, 'libros/primero-lo-primero.jpg', 'Español', 4.5, '1994-01-01'],
            ['Stephen R. Covey', 'The 7 Habits of Highly Effective People', 'English edition of effectiveness guide', 62.00, 'libros/the-7-habits-of-highly-effective-people.jpg', 'Inglés', 4.8, '1989-08-15'],
            ['Dale Carnegie', 'Cómo Ganar Amigos e Influir sobre las Personas', 'Técnicas para relaciones humanas', 48.90, 'libros/como-ganar-amigos-e-influir-sobre-las-personas.jpg', 'Español', 4.6, '1936-10-01'],
            ['Dale Carnegie', 'Cómo Dejar de Preocuparse y Empezar a Vivir', 'Estrategias contra la ansiedad', 45.50, 'libros/como-dejar-de-preocuparse-y-empezar-a-vivir.jpg', 'Español', 4.4, '1948-01-01'],
            ['Dale Carnegie', 'How to Win Friends and Influence People', 'English edition of human relations', 52.00, 'libros/how-to-win-friends-and-influence-people.jpg', 'Inglés', 4.7, '1936-10-01'],
            ['Louise L. Hay', 'Usted Puede Sanar su Vida', 'Transformación a través del pensamiento positivo', 42.90, 'libros/usted-puede-sanar-su-vida.jpg', 'Español', 4.3, '1984-01-01'],
            ['Louise L. Hay', 'El Poder está Dentro de Ti', 'Descubre tu poder interior', 44.50, 'libros/el-poder-esta-dentro-de-ti.jpg', 'Español', 4.2, '1991-01-01'],
            ['Louise L. Hay', 'You Can Heal Your Life', 'English edition of healing guide', 48.00, 'libros/you-can-heal-your-life.jpg', 'Inglés', 4.4, '1984-01-01'],
        ], $categorias, $autores);

        // INFANTIL - Dr. Seuss, Roald Dahl, Astrid Lindgren
        $this->crearLibrosCategoria('Infantil', [
            ['Dr. Seuss', 'El Gato Ensombrerado', 'Gato travieso visita niños', 28.90, 'libros/el-gato-ensombrerado.jpg', 'Español', 4.8, '1957-03-12'],
            ['Dr. Seuss', '¡Cómo el Grinch Robó la Navidad!', 'Grinch arruina la Navidad', 32.50, 'libros/como-el-grinch-robo-la-navidad.jpg', 'Español', 4.7, '1957-10-12'],
            ['Dr. Seuss', 'The Cat in the Hat', 'English edition of mischievous cat', 35.00, 'libros/the-cat-in-the-hat.jpg', 'Inglés', 4.9, '1957-03-12'],
            ['Roald Dahl', 'Charlie y la Fábrica de Chocolate', 'Charlie visita fábrica Wonka', 38.90, 'libros/charlie-y-la-fabrica-de-chocolate.jpg', 'Español', 4.8, '1964-01-17'],
            ['Roald Dahl', 'Matilda', 'Niña inteligente con poderes', 36.50, 'libros/matilda.jpg', 'Español', 4.7, '1988-10-01'],
            ['Roald Dahl', 'Charlie and the Chocolate Factory', 'English edition of Wonka story', 42.00, 'libros/charlie-and-the-chocolate-factory.jpg', 'Inglés', 4.9, '1964-01-17'],
            ['Astrid Lindgren', 'Pippi Calzaslargas', 'Aventuras de Pippi', 34.90, 'libros/pippi-calzaslargas.jpg', 'Español', 4.6, '1945-11-26'],
            ['Astrid Lindgren', 'Los Hermanos Corazón de León', 'Hermanos en Nangijala', 32.50, 'libros/los-hermanos-corazon-de-leon.jpg', 'Español', 4.5, '1973-01-01'],
            ['Astrid Lindgren', 'Pippi Longstocking', 'English edition of Pippi adventures', 38.00, 'libros/pippi-longstocking.jpg', 'Inglés', 4.7, '1945-11-26'],
        ], $categorias, $autores);

        // JUVENIL - Suzanne Collins, Rick Riordan, John Green
        $this->crearLibrosCategoria('Juvenil', [
            ['Suzanne Collins', 'Los Juegos del Hambre', 'Katniss en competencia mortal', 45.90, 'libros/los-juegos-del-hambre.jpg', 'Español', 4.7, '2008-09-14'],
            ['Suzanne Collins', 'En Llamas', 'Secuela de Juegos del Hambre', 48.50, 'libros/en-llamas.jpg', 'Español', 4.6, '2009-09-01'],
            ['Suzanne Collins', 'The Hunger Games', 'English edition of survival story', 52.00, 'libros/the-hunger-games.jpg', 'Inglés', 4.8, '2008-09-14'],
            ['Rick Riordan', 'El Ladrón del Rayo', 'Percy Jackson semidiós', 42.90, 'libros/el-ladron-del-rayo.jpg', 'Español', 4.6, '2005-06-28'],
            ['Rick Riordan', 'El Mar de los Monstruos', 'Percy salva Campamento Mestizo', 44.50, 'libros/el-mar-de-los-monstruos.jpg', 'Español', 4.5, '2006-04-01'],
            ['Rick Riordan', 'The Lightning Thief', 'English edition of Percy Jackson', 48.00, 'libros/the-lightning-thief.jpg', 'Inglés', 4.7, '2005-06-28'],
            ['John Green', 'Bajo la Misma Estrella', 'Hazel y Gus con cáncer', 38.90, 'libros/bajo-la-misma-estrella.jpg', 'Español', 4.5, '2012-01-10'],
            ['John Green', 'Ciudades de Papel', 'Quentin busca a Margo', 36.50, 'libros/ciudades-de-papel.jpg', 'Español', 4.4, '2008-10-16'],
            ['John Green', 'The Fault in Our Stars', 'English edition of cancer love story', 42.00, 'libros/the-fault-in-our-stars.jpg', 'Inglés', 4.6, '2012-01-10'],
        ], $categorias, $autores);

        // AVENTURA - Jules Verne, Robert Louis Stevenson, Mark Twain
        $this->crearLibrosCategoria('Aventura', [
            ['Jules Verne', 'Veinte Mil Leguas de Viaje Submarino', 'Aventuras en el Nautilus', 52.90, 'libros/veinte-mil-leguas-de-viaje-submarino.jpg', 'Español', 4.6, '1870-03-20'],
            ['Jules Verne', 'La Vuelta al Mundo en 80 Días', 'Fogg da la vuelta al mundo', 48.50, 'libros/la-vuelta-al-mundo-en-80-dias.jpg', 'Español', 4.5, '1872-01-30'],
            ['Jules Verne', 'Twenty Thousand Leagues Under the Sea', 'English edition of submarine adventure', 56.00, 'libros/twenty-thousand-leagues-under-the-sea.jpg', 'Inglés', 4.7, '1870-03-20'],
            ['Robert Louis Stevenson', 'La Isla del Tesoro', 'Jim Hawkins busca tesoro', 45.90, 'libros/la-isla-del-tesoro.jpg', 'Español', 4.7, '1883-05-23'],
            ['Robert Louis Stevenson', 'El Extraño Caso del Dr. Jekyll y Mr. Hyde', 'Monstruo interior', 42.50, 'libros/el-extrano-caso-del-dr-jekyll-y-mr-hyde.jpg', 'Español', 4.4, '1886-01-05'],
            ['Robert Louis Stevenson', 'Treasure Island', 'English edition of pirate adventure', 50.00, 'libros/treasure-island.jpg', 'Inglés', 4.8, '1883-05-23'],
            ['Mark Twain', 'Las Aventuras de Tom Sawyer', 'Travesuras en Mississippi', 44.90, 'libros/las-aventuras-de-tom-sawyer.jpg', 'Español', 4.5, '1876-12-01'],
            ['Mark Twain', 'Las Aventuras de Huckleberry Finn', 'Huck y Jim en Mississippi', 46.50, 'libros/las-aventuras-de-huckleberry-finn.jpg', 'Español', 4.6, '1884-12-10'],
            ['Mark Twain', 'The Adventures of Tom Sawyer', 'English edition of Mississippi adventures', 48.00, 'libros/the-adventures-of-tom-sawyer.jpg', 'Inglés', 4.7, '1876-12-01'],
        ], $categorias, $autores);

        // CLÁSICOS - Miguel de Cervantes, William Shakespeare, Fiódor Dostoyevski
        $this->crearLibrosCategoria('Clásicos', [
            ['Miguel de Cervantes', 'Don Quijote de la Mancha', 'Obra maestra de la literatura española', 65.90, 'libros/don-quijote-de-la-mancha.jpg', 'Español', 4.8, '1605-01-16'],
            ['Miguel de Cervantes', 'Novelas Ejemplares', 'Colección de novelas cortas', 58.50, 'libros/novelas-ejemplares.jpg', 'Español', 4.6, '1613-01-01'],
            ['Miguel de Cervantes', 'Don Quixote', 'English edition of Spanish masterpiece', 72.00, 'libros/don-quixote.jpg', 'Inglés', 4.9, '1605-01-16'],
            ['William Shakespeare', 'Romeo y Julieta', 'Historia de amor trágico', 42.90, 'libros/romeo-y-julieta.jpg', 'Español', 4.7, '1597-01-01'],
            ['William Shakespeare', 'Hamlet', 'Príncipe busca venganza', 45.50, 'libros/hamlet.jpg', 'Español', 4.8, '1603-01-01'],
            ['William Shakespeare', 'Romeo and Juliet', 'English edition of tragic love', 48.00, 'libros/romeo-and-juliet.jpg', 'Inglés', 4.9, '1597-01-01'],
            ['Fiódor Dostoyevski', 'Crimen y Castigo', 'Raskólnikov enfrenta consecuencias', 55.90, 'libros/crimen-y-castigo.jpg', 'Español', 4.8, '1866-01-01'],
            ['Fiódor Dostoyevski', 'Los Hermanos Karamázov', 'Novela filosófica sobre moralidad', 68.50, 'libros/los-hermanos-karamazov.jpg', 'Español', 4.7, '1880-01-01'],
            ['Fiódor Dostoyevski', 'Crime and Punishment', 'English edition of psychological novel', 62.00, 'libros/crime-and-punishment.jpg', 'Inglés', 4.9, '1866-01-01'],
        ], $categorias, $autores);

        // TERROR - Stephen King, H.P. Lovecraft, Bram Stoker
        $this->crearLibrosCategoria('Terror', [
            ['Stephen King', 'El Resplandor', 'Jack Torrance en Hotel Overlook', 58.90, 'libros/el-resplandor.jpg', 'Español', 4.7, '1977-01-28'],
            ['Stephen King', 'It (Eso)', 'Pennywise el payaso', 72.50, 'libros/it-eso.jpg', 'Español', 4.8, '1986-09-15'],
            ['Stephen King', 'The Shining', 'English edition of haunted hotel', 65.00, 'libros/the-shining.jpg', 'Inglés', 4.9, '1977-01-28'],
            ['H.P. Lovecraft', 'El Llamado de Cthulhu', 'Entidad antigua en océano', 45.90, 'libros/el-llamado-de-cthulhu.jpg', 'Español', 4.6, '1928-02-01'],
            ['H.P. Lovecraft', 'En las Montañas de la Locura', 'Expedición a Antártida', 48.50, 'libros/en-las-montanas-de-la-locura.jpg', 'Español', 4.5, '1936-02-01'],
            ['H.P. Lovecraft', 'The Call of Cthulhu', 'English edition of cosmic horror', 52.00, 'libros/the-call-of-cthulhu.jpg', 'Inglés', 4.7, '1928-02-01'],
            ['Bram Stoker', 'Drácula', 'Conde vampiro en Inglaterra', 52.90, 'libros/dracula.jpg', 'Español', 4.7, '1897-05-26'],
            ['Bram Stoker', 'El Huésped de Drácula', 'Colección de relatos vampíricos', 45.50, 'libros/el-huesped-de-dracula.jpg', 'Español', 4.4, '1914-01-01'],
            ['Bram Stoker', 'Dracula', 'English edition of vampire classic', 58.00, 'libros/dracula-english.jpg', 'Inglés', 4.8, '1897-05-26'],
        ], $categorias, $autores);

        // POESÍA - Pablo Neruda, Emily Dickinson, William Wordsworth
        $this->crearLibrosCategoria('Poesía', [
            ['Pablo Neruda', 'Veinte Poemas de Amor y una Canción Desesperada', 'Poemas de amor y pasión', 38.90, 'libros/veinte-poemas-de-amor-y-una-cancion-desesperada.jpg', 'Español', 4.8, '1924-06-15'],
            ['Pablo Neruda', 'Canto General', 'Epopeya poética de América Latina', 45.50, 'libros/canto-general.jpg', 'Español', 4.6, '1950-01-01'],
            ['Pablo Neruda', 'Twenty Love Poems and a Song of Despair', 'English edition of love poems', 42.00, 'libros/twenty-love-poems-and-a-song-of-despair.jpg', 'Inglés', 4.7, '1924-06-15'],
            ['Emily Dickinson', 'Poemas Completos', 'Colección completa de poemas', 52.90, 'libros/poemas-completos-emily-dickinson.jpg', 'Español', 4.7, '1890-01-01'],
            ['Emily Dickinson', 'Poemas Seleccionados', 'Selección de mejores poemas', 38.50, 'libros/poemas-seleccionados-emily-dickinson.jpg', 'Español', 4.5, '1890-01-01'],
            ['Emily Dickinson', 'The Complete Poems of Emily Dickinson', 'English edition of complete works', 58.00, 'libros/the-complete-poems-of-emily-dickinson.jpg', 'Inglés', 4.8, '1890-01-01'],
            ['William Wordsworth', 'Baladas Líricas', 'Poemas que revolucionaron la poesía', 42.90, 'libros/baladas-liricas.jpg', 'Español', 4.4, '1798-01-01'],
            ['William Wordsworth', 'El Preludio', 'Poema autobiográfico', 48.50, 'libros/el-preludio.jpg', 'Español', 4.3, '1850-01-01'],
            ['William Wordsworth', 'Lyrical Ballads', 'English edition of revolutionary poetry', 45.00, 'libros/lyrical-ballads.jpg', 'Inglés', 4.6, '1798-01-01'],
        ], $categorias, $autores);

        // ARTE - Ernst Gombrich, David Hockney, John Berger
        $this->crearLibrosCategoria('Arte', [
            ['Ernst Gombrich', 'Historia del Arte', 'Introducción completa al arte', 85.90, 'libros/historia-del-arte-gombrich.jpg', 'Español', 4.8, '1950-01-01'],
            ['Ernst Gombrich', 'Arte e Ilusión', 'Psicología de la representación', 72.50, 'libros/arte-e-ilusion.jpg', 'Español', 4.6, '1960-01-01'],
            ['Ernst Gombrich', 'The Story of Art', 'English edition of art history', 92.00, 'libros/the-story-of-art.jpg', 'Inglés', 4.9, '1950-01-01'],
            ['David Hockney', 'Secret Knowledge', 'Instrumentos ópticos en arte', 78.90, 'libros/secret-knowledge.jpg', 'Español', 4.5, '2001-01-01'],
            ['David Hockney', 'Una Historia de las Imágenes', 'Viaje visual por el arte', 82.50, 'libros/una-historia-de-las-imagenes.jpg', 'Español', 4.4, '2016-01-01'],
            ['David Hockney', 'A History of Pictures', 'English edition of visual journey', 88.00, 'libros/a-history-of-pictures.jpg', 'Inglés', 4.6, '2016-01-01'],
            ['John Berger', 'Modos de Ver', 'Análisis de cómo vemos el arte', 45.90, 'libros/modos-de-ver.jpg', 'Español', 4.7, '1972-01-01'],
            ['John Berger', 'Sobre el Dibujo', 'Reflexión sobre el acto de dibujar', 38.50, 'libros/sobre-el-dibujo.jpg', 'Español', 4.3, '2005-01-01'],
            ['John Berger', 'Ways of Seeing', 'English edition of art analysis', 52.00, 'libros/ways-of-seeing.jpg', 'Inglés', 4.8, '1972-01-01'],
        ], $categorias, $autores);

        $this->command->info('Libros creados exitosamente: ' . Libro::count());
    }

    private function crearLibrosCategoria($nombreCategoria, $libros, $categorias, $autores)
    {
        $categoria = $categorias[$nombreCategoria];
        
        foreach ($libros as $libro) {
            [$nombreAutor, $titulo, $descripcion, $precio, $imagen, $idioma, $valoracion, $fecha] = $libro;
            
            Libro::create([
                'titulo' => $titulo,
                'descripcion' => $descripcion,
                'precio' => $precio,
                'stock' => rand(10, 50),
                'imagen' => $imagen,
                'categoria_id' => $categoria->id,
                'autor_id' => $autores[$nombreAutor]->id,
                'idioma' => $idioma,
                'valoracion' => $valoracion,
                'publicado_en' => $fecha,
            ]);
        }
    }
}
