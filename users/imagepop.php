<div class="row properties">
    <div class="col-lg-12">
        <div class="card property-box mb-3">
            <div class="row g-0">
                <div class="col-md-12 col-lg-4 col-sm-12 property-image">
                    <div class="image-placeholder">
                        <?php if (count($images) > 0) { ?>
                            <div id="propertySlider<?php echo $row['id']; ?>" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <?php
                                    foreach ($images as $index => $image) {
                                        $active = $index == 0 ? 'active' : '';
                                        echo "<div class='carousel-item $active'>
                                            <img src='$image' class='d-block w-100' alt='Property Image' onclick='openImagePopup($row[id])'>
                                          </div>";
                                    }
                                    ?>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#propertySlider<?php echo $row['id']; ?>" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#propertySlider<?php echo $row['id']; ?>" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="col-md-12 col-lg-2 col-sm-12 property-details">
                    <div class="detail-item">Rent- <?php echo $row['expected_rent']; ?></div>
                    <div class="detail-item">Location - <?php echo $row['city']; ?></div>
                    <div class="detail-item_area">Area- <?php echo $row['build_up_area']; ?> sqft</div>
                </div>

                <div class="col-md-12 col-lg-6 col-sm-12">
                    <div class="property-body">
                        <div class="property-info">
                            <div class="info-item">
                                <?php echo $row['furnishing']; ?><br><span>Furnishing</span></div>
                            <div class="info-item"><?php echo $row['bhk_type']; ?><br><span>Apartment Type</span></div>
                            <div class="info-item"><?php echo $row['preferred_tenants']; ?><br><span>Tenant Type</span></div>
                            <div class="info-item">
                                <?php echo $row['available_from']; ?><br><span>Available</span></div>
                        </div>

                        <div class="property-hylt">
                            <p class="property-highlight" onclick="showPropertyDetails(<?php echo $row['id']; ?>)">
                                Property Highlight
                            </p>

                            <p class="property-id"><b>Property Id : </b><span><?php echo $row['id']; ?></span></p>
                        </div>

                        <div class="contact-property">
                            <div class="contact-button">
                                <a class="btn btn-primary book-service" data-property-id="<?php echo $row['id']; ?>" data-property-type="<?php echo $row['property_type']; ?>" data-service-name="<?php echo $row['bhk_type']; ?>" onclick="openModalCustom('<?php echo $row['bhk_type']; ?>', '<?php echo $row['property_type']; ?>')">
                                    Schedule visit
                                </a>
                                <div class="heart-iocns">
                                    <i class="fa-regular fa-heart" onclick="saveProperty(<?php echo $row['id']; ?>, this)"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Popup Modal -->
<div class="modal fade" id="imagePopup<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="imagePopupLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imagePopupLabel">Property Images</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="popupCarousel<?php echo $row['id']; ?>" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                        foreach ($images as $index => $image) {
                            $active = $index == 0 ? 'active' : '';
                            echo "<div class='carousel-item $active'>
                                <img src='$image' class='d-block w-100' alt='Property Image'>
                              </div>";
                        }
                        ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#popupCarousel<?php echo $row['id']; ?>" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#popupCarousel<?php echo $row['id']; ?>" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function openImagePopup(propertyId) {
    const modalId = `#imagePopup${propertyId}`;
    const modal = new bootstrap.Modal(document.querySelector(modalId));
    modal.show();
}
</script>
