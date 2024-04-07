<?php if (!empty($section) && $section['type'] === 'contactInf'): ?>
    <div class="contact-container" style="background: #FFF; padding: 50px;">
        <div class="heading-container" style="padding-left: 35px;">
            <h3 class="display-3 text-left" style="color: black; font-size: 40px; font-family: Aleo; font-weight: 700; line-height: 45px;">
                <span class="title" style="border-bottom: 6px solid black;"><?= htmlspecialchars($section['restaurantName']); ?></span>
            </h3>
        </div>
        <?php foreach ($section['paragraphs'] as $paragraph): ?>
            <p style="font-size: 20px; font-family: 'Aleo', serif; font-weight: 400; padding-left: 45px; margin-bottom: 30px;">
                <?= htmlspecialchars($paragraph['text']); ?>
            </p>
        <?php endforeach; ?>
        <ul style="list-style: none; padding-left: 45px; font-family: 'Aleo', serif;">
            <li style="margin-bottom: 10px;">
                <span style="font-weight: 700;">Drop By:</span> <?= htmlspecialchars($section['location']); ?>
            </li>
            <li style="margin-bottom: 10px;">
                <span style="font-weight: 700;">Give Us a Ring:</span> <?= htmlspecialchars($section['phonenumber']); ?>
            </li>
            <li style="margin-bottom: 10px;">
                <span style="font-weight: 700;">Send an Email:</span> <?= htmlspecialchars($section['email']); ?>
            </li>
        </ul>

    </div>
    <div class="image-container">
        <a href="/restaurant/yummyHome">
            <img src="/img/yummyImages/img_5.png" alt="Yummy Image">
        </a>
    </div>
<?php endif; ?>

<style>
    .contact-container {
        max-width: 600px; /* or whatever max-width fits your design */
        background: #FFF; /* Adjust if needed */
        padding: 50px; /* Adjust padding to match your design */
        font-family: 'Aleo', serif;
    }

    .contact-container h3 {
        font-size: 30px; /* Adjust font size as needed */
        font-weight: 700; /* Adjust font weight as needed */
        margin-bottom: 20px; /* Adjust spacing as needed */
    }

    .contact-container p {
        font-size: 20px; /* Adjust font size as needed */
        font-weight: 400; /* Adjust font weight as needed */
        margin-bottom: 30px; /* Adjust spacing as needed */
    }

    .contact-container ul {
        list-style: none;
        padding: 0;
    }

    .contact-container li {
        font-size: 20px; /* Adjust font size as needed */
        margin-bottom: 10px; /* Adjust spacing as needed */
    }

    .image-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 90px; /* Adjust the height as needed */
        margin-bottom: 50px;
    }

    .image-container img {
        max-height: 90px;
        width: auto;
    }

</style>

