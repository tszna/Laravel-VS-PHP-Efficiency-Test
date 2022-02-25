# Laravel VS PHP Efficiency Test
Jest to prosty projekt, który pozwala sprawdzić jaka jest wydajność pobierania 210 000 danych z bazy danych mysql, w przypadku pobierania z wykorzystaniem eloquenta od laravela i czystego php. Test sprawdza prędkość pobierania oraz wykorzystanie pamięci RAM.
<h4>Uruchomienie projektu</h4>
W celu uruchomienie projektu należy uruchomić terminal w katalogu efficiencyTest, a następnie wpisać komendę:
<pre><code>composer install</code></pre>
Następnie w bazie mysql utworzyć bazę danych o nazwie: efficiency_test, i użytkownika z uprawnieniami do tej bazy danych o loginie: efficiency_test i haśle: efficiency_test. Należy również upewnić się, czy dane w pliku env (szczególnie port bazy danych) są zgodne z konfiguracją naszej bazy danych.
<h4>Uruchomienie testu</h4>
Aby wykonać test należy najpierw zapełnić baze danych danymi, w tym celu należy wpisać w terminal komendę:
<pre><code>php artisan migrate:fresh --seed</code></pre>
a po zakończeniu tego procesu test można wykonać przy pomocy komendy:
<pre><code>php artisan test .\tests\Unit\EfficiencyTest.php</code></pre>
Wyniki zostaną wyświetlone w terminalu.