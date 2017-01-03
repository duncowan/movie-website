<!DOCTYPE html>

<!--
    Hitchcock category page.
-->

<html lang="en">
        <?php
            $scripts = array("scripts/cookie.js", "scripts/reviews.js", "scripts/showHide.js", "scripts/cart.js");
            include("noaccess/header.php");

            function addReviewForm($xmlFileName) {
                if (isset($_SESSION['authenticatedUser'])) {
                    echo "<form action='noaccess/addReview.php' method='POST'>";
                    echo " <input type='hidden' name='xmlFileName' value='$xmlFileName'>";
                    echo "<label for='rating'>Rating: </label>";
                    echo " <select name='rating' id='rating'>";
                    for ($i = 1; $i <= 5; $i++) {
                        echo "<option value='$i'>$i</option>";
                    }
                    echo " </select>";
                    echo " <input type='submit' name='Submit' value='Submit'>";
                    echo "</form>";
                }
            }
        ?>

        <div id="main">
            <h2>Alfred Hitchcock</h2>

            <section class="film">
                <img src="images/The_Birds.jpg" alt="The Birds">
                <h3>The Birds (1963)</h3>
                <p>Directed by: Alfred Hitchcock</p>
                <p>Starring: Rod Taylor, Jessica Tandy, Suzanne Pleshette, Tippi Hedren</p>
                <p>The follow up to his box office sensation, <em>Psycho</em>, the Birds mixes suspense and horror from an everyday source.</p>
                <p>
                $<span class="price">14.99</span>
                <input type="button" value="Add to Cart" class="buy">
                </p>
                <?php addReviewForm("reviews/The_Birds.xml"); ?>
            </section>

            <section class="film">
                <img src="images/Dial_M_for_Murder.jpg" alt="Dial M for Murder">
                <h3>Dial M for Murder (1954)</h3>
                <p>Directed by: Alfred Hitchcock</p>
                <p>Starring: Ray Milland, Grace Kelly, Robert Cimmings, John Williams</p>
                <p>Shot in 3D, but only released in 2D because of lack of interest in the process, it was shown in 3D in the 1980s, and has recently been released in 3D Blu-ray format.</p>
                <p>
                $<span class="price">12.99</span>
                <input type="button" value="Add to Cart" class="buy">
                </p>
                <?php addReviewForm("reviews/Dial_M_for_Murder.xml"); ?>
            </section>

            <section class="film">
                <img src="images/The_Man_Who_Knew_Too_Much.jpg" alt="The Man Who Knew Too Much">
                <h3>The Man Who Knew Too Much (1956)</h3>
                <p>Directed by: Alfred Hitchcock</p>
                <p>Starring: James Stewart, Doris Day, Brenda De Banzie, Bernard Miles, Alan Mowbray, Hillary Brooke, Christopher Olsen</p>
                <p>Hitchcock's remake of his own earlier (1934) version.</p>
                <p>
                $<span class="price">11.99</span>
                <input type="button" value="Add to Cart" class="buy">
                </p>
                <?php addReviewForm("reviews/The_Man_Who_Knew_Too_Much.xml"); ?>
            </section>

            <section class="film">
                <img src="images/North_by_Northwest.jpg" alt="North by Northwest">
                <h3>North by Northwest (1959)</h3>
                <p>Directed by: Alfred Hitchcock</p>
                <p>Starring: Cary Grant, Eva Marie Saint, James Mason, Jessie Royce Landis</p>
                <p>A classic thriller in which an innocent man is pursued by mysterious agents over government secrets.</p>
                <p>
                $<span class="price">14.99</span>
                <input type="button" value="Add to Cart" class="buy">
                </p>
                <?php addReviewForm("reviews/North_by_Northwest.xml"); ?>
            </section>

            <section class="film">
                <img src="images/Vertigo.jpg" alt="Vertigo">
                <h3>Vertigo (1958)</h3>
                <p>Directed by: Alfred Hitchcock</p>
                <p>Starring: James Stuart, Kim Novak, Barbara Bel Geddes</p>
                <p>A classic piece of Hitchcock, often included in lists of the best films of all time.</p>
                <p>
                $<span class="price">16.99</span>
                <input type="button" value="Add to Cart" class="buy">
                </p>
                <?php addReviewForm("reviews/Vertigo.xml"); ?>
            </section>
        </div>

        <?php include("noaccess/footer.php"); ?>
    </body>
</html>
