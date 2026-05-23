<?php
require_once __DIR__ . '/../../config/database.php';
?>

<div class="edit-toast" id="editToast">
    <i class="ri-checkbox-circle-line"></i><span>Listing updated successfully</span>
</div>

<div class="edit-listing-page">

    <div class="edit-listing-header">
        <a href="?page=profile" class="edit-listing-back">
            <i class="ri-arrow-left-line"></i> Back
        </a>
        <div>
            <h1 class="edit-listing-title">Edit Listing</h1>
            <p class="edit-listing-sub">Make changes and save when you're done</p>
        </div>
    </div>

    <div class="edit-listing-card">

        <div class="edit-photos-section" id="editPhotosSection" style="display:none">
            <p class="edit-photos-label">Current Photos</p>
            <div class="edit-photos-grid" id="editPhotosGrid"></div>
        </div>

        <form id="edit_listing_form">

            <div class="sell-field">
                <label for="listingTitle">Title</label>
                <input class="sell-input" type="text" id="listingTitle" placeholder="What are you selling?">
            </div>

            <div class="sell-field">
                <label for="listingDescription">Description</label>
                <textarea class="sell-textarea" id="listingDescription" placeholder="Describe your item"></textarea>
            </div>

            <div class="sell-row">
                <div class="sell-field">
                    <label for="listingCategory">Category</label>
                    <select class="sell-select" id="listingCategory">
                        <option value="" disabled>Select a category</option>
                        <option value="electronics">Electronics</option>
                        <option value="clothing">Clothing</option>
                        <option value="home">Home</option>
                        <option value="vehicles">Vehicles</option>
                        <option value="furniture">Furniture</option>
                        <option value="books">Books</option>
                        <option value="sports">Sports</option>
                        <option value="baby">Baby</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div class="sell-field">
                    <label for="listingCondition">Condition</label>
                    <select class="sell-select" id="listingCondition">
                        <option value="" disabled>Select condition</option>
                        <option value="new">New</option>
                        <option value="like_new">Like New</option>
                        <option value="good">Good</option>
                        <option value="fair">Fair</option>
                        <option value="parts">For Parts / Spares</option>
                    </select>
                </div>
            </div>

            <div class="sell-row">
                <div class="sell-field">
                    <label for="listingPrice">Price (ZAR)</label>
                    <div class="price-wrapper">
                        <span class="price-prefix">R</span>
                        <input class="sell-input" type="number" id="listingPrice" placeholder="0.00" min="0" step="0.01">
                    </div>
                </div>

                <div class="sell-field">
                    <label for="listingLocation">Location</label>
                    <input class="sell-input" type="text" id="listingLocation" placeholder="City or suburb">
                </div>
            </div>

            <div class="sell-field">
                <label for="listingPhoneNum">Phone Number <span class="optional">(optional)</span></label>
                <input class="sell-input" type="tel" id="listingPhoneNum" placeholder="e.g. 071 234 5678">
            </div>

            <div class="edit-listing-actions">
                <button type="button" class="edit-save-btn" id="update-listing">
                    <i class="ri-save-line"></i> Save Changes
                </button>
                <button type="button" class="edit-relist-btn" id="relist-listing" style="display:none">
                    <i class="ri-refresh-line"></i> Relist Item
                </button>
                <button type="button" class="edit-remove-btn" id="remove-listing">
                    <i class="ri-delete-bin-line"></i> Remove Listing
                </button>
            </div>

        </form>

    </div>

</div>

<script>
    const queryString = window.location.search;
    const urlParams   = new URLSearchParams(queryString);
    const listingID   = urlParams.get('listingID');

    function showToast(msg = 'Listing updated successfully') {
        const toast = document.getElementById('editToast');
        toast.querySelector('span').textContent = msg;
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 3000);
    }

    async function getListingInfo(data) {
        try {
            const response = await fetch('../api/listing/load_listing.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });

            const result = await response.json();
            if (!result.success) { alert(result.message); return; }

            const l = result.listingInfo;
            document.getElementById('listingTitle').value       = l.title;
            document.getElementById('listingPrice').value       = l.price;
            document.getElementById('listingCategory').value    = l.category;
            document.getElementById('listingCondition').value   = l.itemCondition;
            document.getElementById('listingDescription').value = l.description;
            document.getElementById('listingLocation').value    = l.location;
            document.getElementById('listingPhoneNum').value    = l.phoneNum;

            if (l.status === 'removed') {
                document.getElementById('update-listing').style.display = 'none';
                document.getElementById('relist-listing').style.display = '';
                document.getElementById('remove-listing').style.display = 'none';
            }

            if (result.images && result.images.length > 0) {
                const section = document.getElementById('editPhotosSection');
                const grid    = document.getElementById('editPhotosGrid');
                section.style.display = 'block';

                grid.innerHTML = result.images.map((img, i) => `
                    <div class="edit-photo-item">
                        <img src="uploads/listings/${listingID}/${img.filename}" alt="Photo ${i + 1}">
                        ${i === 0 ? '<span class="cover-badge">Cover</span>' : ''}
                    </div>
                `).join('');
            }

        } catch (error) {
            alert('Something went wrong loading the listing.');
            console.error(error);
        }
    }

    getListingInfo({ listingID });

    async function updateListing() {
        const formData = {
            listingID,
            listingTitle:       document.getElementById('listingTitle').value,
            listingPrice:       document.getElementById('listingPrice').value,
            listingCategory:    document.getElementById('listingCategory').value,
            listingCondition:   document.getElementById('listingCondition').value,
            listingDescription: document.getElementById('listingDescription').value,
            listingLocation:    document.getElementById('listingLocation').value,
            listingPhoneNum:    document.getElementById('listingPhoneNum').value,
        };

        try {
            const res    = await fetch('../api/listing/edit_listing.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(formData)
            });
            const result = await res.json();
            if (result.success) {
                showToast();
            } else {
                alert(result.message);
            }
        } catch (err) {
            alert('Something went wrong saving changes.');
            console.error(err);
        }
    }

    async function removeListing() {
        if (!confirm('Are you sure you want to remove this listing? This cannot be undone.')) return;

        try {
            const res    = await fetch('../api/listing/remove_listing.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ listingID })
            });
            const result = await res.json();
            if (result.success) {
                window.location.href = '?page=profile';
            } else {
                alert(result.message);
            }
        } catch (err) {
            alert('Something went wrong removing the listing.');
            console.error(err);
        }
    }

    async function relistListing() {
        const formData = {
            listingID,
            listingTitle:       document.getElementById('listingTitle').value,
            listingPrice:       document.getElementById('listingPrice').value,
            listingCategory:    document.getElementById('listingCategory').value,
            listingCondition:   document.getElementById('listingCondition').value,
            listingDescription: document.getElementById('listingDescription').value,
            listingLocation:    document.getElementById('listingLocation').value,
            listingPhoneNum:    document.getElementById('listingPhoneNum').value,
        };

        try {
            const res    = await fetch('../api/listing/relist_listing.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(formData)
            });
            const result = await res.json();
            if (result.success) {
                document.getElementById('relist-listing').style.display  = 'none';
                document.getElementById('update-listing').style.display  = '';
                document.getElementById('remove-listing').style.display  = '';
                showToast('Listing relisted successfully');
            } else {
                alert(result.message);
            }
        } catch (err) {
            alert('Something went wrong relisting.');
            console.error(err);
        }
    }

    document.getElementById('update-listing').addEventListener('click', updateListing);
    document.getElementById('relist-listing').addEventListener('click', relistListing);
    document.getElementById('remove-listing').addEventListener('click', removeListing);
</script>
