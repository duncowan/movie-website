<!DOCTYPE html>

<!--
    Sci-Fi category page.
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
            <h2>Science Fiction and Horror</h2>

            <section class="film">
                <img src="images/Attack_of_the_50ft_Woman.jpg" alt="Attack of the 50ft Woman">
                <h3>Attack of the 50 Foot Woman (1958)</h3>
                <p>Directed by: Nathan H. Juran</p>
                <p>Starring: Alison Hayes, William Hudson, Yvette Vickers</p>
                <p>A low-budget cult camp classic.</p>
                <p>
                $<span class="price">8.99</span>
                <input type="button" value="Add to Cart" class="buy">
                </p>
                <?php addReviewForm("reviews/Attack_of_the_50ft_Woman.xml"); ?>
            </section>

            <section class="film">
                <img src="images/The_Day_of_the_Triffids.jpg" alt="The Day of the Triffids">
                <h3>The Day of the Triffids (1962)</h3>
                <p>Directed by: Steve Sekely</p>
                <p>Starring: Howard Keel, Kieron Moore, Janatte Scott, Nicole Maurey, Mervyn Johns</p>
                <p>A not-particularly-faithful adaptation of John Wyndham's classic novel.</p>
                <p>
                $<span class="price">7.99</span>
                <input type="button" value="Add to Cart" class="buy">
                </p>
                <?php addReviewForm("reviews/The_Day_of_the_Triffids.xml"); ?>
            </section>

            <section class="film">
                <img src="images/Forbidden_Planet.jpg" alt="Forbidden Planet">
                <h3>Forbidden Planet (1956)</h3>
                <p>Directed by: Fred M. Wilcox</p>
                <p>Starring: Walter Pidgeon, Anne Francis, Leslie Nielsen, Warren Stevens, Robby the Robot</p>
                <p>One of the great science fiction films of the 1950s, and the first appearance of science fiction icon Robby the Robot.</p>
                <p>
                $<span class="price">13.99</span>
                <input type="button" value="Add to Cart" class="buy">
                </p>
                <?php addReviewForm("reviews/Forbidden_Planet.xml"); ?>
            </section>

            <section class="film">
                <img src="images/King_Kong.jpg" alt="King Kong">
                <h3>King Kong (1933)</h3>
                <p>Directed by: Merian C. Cooper, Ernest B. Schoedsack</p>
                <p>Starring: Fay Wray, Bruce Cabot, Robert Armstrong</p>
                <p>The original classic stop-motion masterpiece. Who needs CGI anyway?</p>
                <p>
                $<span class="price">11.99</span>
                <input type="button" value="Add to Cart" class="buy">
                </p>
                <?php addReviewForm("reviews/King_Kong.xml"); ?>
            </section>

            <section class="film">
                <img src="images/The_Mummy.jpg" alt="The Mummy">
                <h3>The Mummy (1932)</h3>
                <p>Directed by: Karl Freund</p>
                <p>Starring: Boris Karloff, Zita Johann, David Manners, Edward van Sloan</p>
                <p>Boris Karloff, best known for his role as Frankenstein's Monster, takes on the guise of the ancient Egyptian priest Imhotep returned from the dead to seek his lost love.</p>
                <p>
                $<span class="price">9.99</span>
                <input type="button" value="Add to Cart" class="buy">
                </p>
                <?php addReviewForm("reviews/The_Mummy.xml"); ?>
            </section>

            <section class="film">
                <img src="images/Plan_9_from_Outer_Space.jpg" alt="Plan 8 from Outer Space">
                <h3>Plan 9 from Outer Space (1959)</h3>
                <p>Directed by: Ed Wood</p>
                <p>Starring: Gregory Walcott, Mona McKinnon, Tom Keene, Tor Johnson, Dudley Manlove, Joanna Lee, John Breckinridge, Vampira, Bela Lugosi</p>
                <p>Not much science and plenty of fiction. Considered by some to be the worst film ever made, it's so bad it's good!</p>
                <p>
                $<span class="price">14.99</span>
                <input type="button" value="Add to Cart" class="buy">
                </p>
                <?php addReviewForm("reviews/Plan_9_from_Outer_Space.xml"); ?>
            </section>

            <section class="film">
                <img src="images/Tarantula.jpg" alt="Tarantula">
                <h3>Tarantula (1955)</h3>
                <p>Directed by: Jack Arnold</p>
                <p>Starring: John Agar, Mara Corday, Leo G. Carroll</p>
                <p>What's scarier than a 50 foot woman? A 100 foot spider! Not one for arachnophobes.</p>
                <p>
                $<span class="price">7.99</span>
                <input type="button" value="Add to Cart" class="buy">
                </p>
                <?php addReviewForm("reviews/Tarantula.xml"); ?>
            </section>
        </div>

        <?php include("noaccess/footer.php"); ?>
    </body>
</html>
