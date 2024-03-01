<div class="timetable-container" style="display: flex; align-items: center; justify-content: flex-start; height: 80vh; width: 90%; background-color: rgba(79, 224, 238, 0.3); margin: 50px; padding-left: 15%;
padding-right: 15%; gap: 7em;">
    <div class="timetable" style="display: flex; align-items: center;">
        <div class="icon" style="margin-left: 0;">
            <?php if (!empty($section['locations'])): ?>
                <?php foreach ($section['locations'] as $location): ?>
                    <?php if (!empty($location['icon'])): ?>
                        <img id="icon_<?php echo $location['historyId']; ?>" src="<?php echo $location['icon']; ?>" alt=""
                             style="width: 40px; height: 40px; margin-left: 0;">
                    <?php else: ?>
                        <!-- If icon is empty, set background image using CSS -->
                        <div class="icon-placeholder" id="icon_<?php echo $location['historyId']; ?>"
                             style="height: 73px; background-color: rgba(70, 200, 230, 0); background-size: cover;"></div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="button-container" style="display: flex; flex-direction: column; align-items: flex-end; margin-right: 5px; z-index: 1; margin-left: 15px;">
            <?php if (!empty($section['locations'])): ?>
                <?php foreach ($section['locations'] as $location): ?>
                    <div class="button-col">
                        <div class="buttons">
                            <button id="button" class="timetable-button" onclick="toggleDescription(<?php echo $location['historyId']; ?>)"
                                    style="width: 30px; height: 30px; border-radius: 50%; background-color: #006D77; color: white; margin: 18px; border: none; align-content: center;"><?php echo $location['button']; ?></button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="line" style="position: absolute; width: 4px; background-color: black; height: 58%; margin-left: 86px; z-index: 0;"></div>

        <div class="locationName" style="margin-left: 0;">
            <?php if (!empty($section['locations'])): ?>
                <?php foreach ($section['locations'] as $location): ?>
                    <div class="name-col">
                        <div class="name">
                            <button id="name_button" class="name-button" onclick="toggleDescription(<?php echo $location['historyId']; ?>)"
                                    style="background: none; width: 250px; border: none; font-size: 22px; font-weight: bold; margin: 15px; text-align: left;"><?php echo $location['location']; ?></button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="card-container" style="margin-left: 60px;">
        <div class="card" style="padding: 20px; border: 1px solid #ccc; border-radius: 5px; width: 800px; height: 700px; background-color: rgba(88, 47, 14, 1); color: white;">
            <div class="cardImage">
                <?php if (!empty($section['locations'])): ?>
                    <?php foreach ($section['locations'] as $index => $location): ?>
                        <img id="image_<?php echo $location['historyId']; ?>" src="<?php echo $location['locationPicture']; ?>"
                             style="width: 100%; height: 400px; border-radius: 5px; margin-bottom: 10px; <?php echo ($index == 0) ? 'display: block;' : 'display: none;'; ?>"
                             alt="">
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="cardDescription">
                <?php if (!empty($section['locations'])): ?>
                    <?php foreach ($section['locations'] as $index => $location): ?>
                        <p id="description_<?php echo $location['historyId']; ?>"
                           style="font-size: 18px; line-height: 2; <?php echo ($index == 0) ? 'display: block;' : 'display: none;'; ?>">
                            <?php echo $location['description']; ?>
                        </p>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

    <div class="map-container" style="background-color: #582F0E; border-radius: 30px; margin: 5%;">
    <p style="color: white; margin-left: 80px; font-family: Aleo, serif; font-size: 50px;">Tour Route</p>
    <div class="route" style="justify-content: space-between; display: flex;">
        <div class="map" id="map" style="margin: 3%; width: 60%; height: 400px;"></div>
        <div class="listing"
             style="list-style: none; margin-left: 50px; margin-bottom: 10px; text-align: left; width: 40%; color: #FFF; font-family: Aleo, serif; font-size: 30px; font-weight: 700; line-height: 60px;">
            <?php if (!empty($section['locations'])): ?>
                <?php foreach ($section['locations'] as $location): ?>
                    <li id="subsection"><?php echo $location['button']; ?>. <?php echo $location['location']; ?></li>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    button:hover
    {
        color: #006D77;
        font-weight: bold;
    }
</style>

<script src="/javascript/historyComponents.js"></script>




