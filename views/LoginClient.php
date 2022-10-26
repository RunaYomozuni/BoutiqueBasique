<link rel="stylesheet" href="../assets/css/normalize.css">
<link rel="stylesheet" href="../assets/css/style.css">
<main>
    <a href="../index.php"><img src="../assets/img/house-solid.svg" alt="house" id="house"></a>
    <article id="slogan">
        <h2> CONNEXION </h2>

    </article>
    <section id='section'>
        <form action="../controllers/Controller.php" method="post" id="formCreate">
            <input type='hidden' name='todo' value='LoginClient'>

            <div>
                <label for="clientNom">Mail</label>
                <input type="email" name="clientMail"  required id="clientMail">
            </div>

            <div>
                <label for="clientNom">Password</label>
                <input type="password" name="clientPassword"  required id="clientPassword">
            </div>

            <div>
                <input type="submit" name="submitLoginClient" id="submit">
            </div>
        </form>
    </section>
</main>

</body>
</html>
