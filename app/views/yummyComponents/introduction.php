<?php if (!empty($section) && $section['type'] === 'introduction'): ?>
    <div class="text-left pl-md-1000" style="background-color: #F2F4F3; min-height: 40vh;  padding: 20px">
        <br>
        <br>
        <div class="introHeading" style="height: 96px; display: flex; align-items: center; justify-content: left;">
            <h2 class="introHeading"><?php echo($section['heading']); ?></h2>
        </div>
        <div class="introParagraphs">
            <?php if (!empty($section['paragraphs'])): ?>
                <?php foreach ($section['paragraphs'] as $paragraph): ?>
                    <?php
                    // Use a regular expression to wrap text before ':' in a strong tag
                    $textWithStrong = preg_replace('/^(.*?):/', '<strong>$1:</strong>', htmlspecialchars($paragraph['text']));
                    // Replace each number with a line break before it, if needed
                    $textWithBreaks = preg_replace('/(?<!\A)(\d+\.\s+)/', '<br>$1', $textWithStrong);
                    echo $textWithBreaks;
                    ?>

                <?php endforeach; ?>
            <?php endif; ?>

        </div>
        <?php if (!empty($section['linkText'])): ?>
            <a href="#"><?= htmlspecialchars($section['linkText']); ?></a>
        <?php endif; ?>
    </div>
<?php endif; ?>

<style>
    .introHeading{

    }
    .introParagraphs{

    }

</style>






