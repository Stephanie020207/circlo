<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f3f7fc">
    <meta name="description" content="Edit your Circlo listing.">
    <title>Edit Item — Circlo</title>
    <style>
        :root {
            color-scheme: light;
            --navy: #173f6e;
            --blue: #1d6be1;
            --ink: #203b59;
            --muted: #8293a8;
            --line: #dce6f1;
            --canvas: #f3f7fc;
            --soft: #e7eef7;
            --white: #fff;
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-width: 320px;
            min-height: 100vh;
            margin: 0;
            padding: 7px;
            background: var(--canvas);
            color: var(--ink);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        button,
        input,
        select,
        textarea {
            font: inherit;
        }

        .app-frame {
            display: flex;
            min-height: calc(100vh - 14px);
            overflow: hidden;
            border: 1px solid #e1e9f2;
            border-radius: 13px;
            background: var(--white);
            box-shadow: 0 1px 3px rgba(31, 63, 98, 0.03);
        }

        .sidebar {
            width: 177px;
            flex: 0 0 177px;
            display: flex;
            flex-direction: column;
            padding: 20px 10px 29px;
            border-radius: 11px;
            background: var(--navy);
            color: var(--white);
        }

        .brand {
            padding: 0 10px;
            color: inherit;
            font-size: 25px;
            font-weight: 800;
            letter-spacing: -1.1px;
            line-height: 1.15;
            text-decoration: none;
        }

        .sidebar-nav {
            display: grid;
            gap: 7px;
            margin-top: 31px;
        }

        .sidebar-nav a {
            min-height: 39px;
            display: flex;
            align-items: center;
            padding: 0 12px;
            border-radius: 8px;
            color: #f1f5fb;
            font-size: 12px;
            font-weight: 500;
            text-decoration: none;
            transition: background-color 140ms ease;
        }

        .sidebar-nav a:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar-nav a[aria-current="page"] {
            background: var(--blue);
            font-weight: 700;
        }

        .sidebar-profile {
            margin-top: auto;
            padding: 0 6px;
            color: #f6f8fc;
            font-size: 11px;
            line-height: 1.5;
        }

        .profile-name {
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
        }

        .profile-dot {
            width: 7px;
            height: 7px;
            flex: 0 0 7px;
            border-radius: 50%;
            background: #fff;
        }

        .profile-school {
            margin-top: 4px;
            color: #b9c9dc;
        }

        .main-content {
            min-width: 0;
            flex: 1;
            padding: 12px 17px 20px;
        }

        .search-bar {
            min-height: 60px;
            display: flex;
            align-items: center;
            padding: 10px 15px;
            border: 1px solid var(--line);
            border-radius: 11px;
        }

        .search-input {
            width: min(363px, 100%);
            height: 35px;
            padding: 0 13px;
            border: 1px solid #e7edf5;
            border-radius: 8px;
            outline: none;
            background: #f4f7fb;
            color: var(--ink);
            font-size: 11px;
        }

        .search-input::placeholder {
            color: #8b9bb0;
            opacity: 1;
        }

        .search-input:focus,
        .form-control:focus {
            border-color: #8bb5f0;
            box-shadow: 0 0 0 3px rgba(29, 107, 225, 0.1);
            outline: none;
        }

        .page-content {
            padding: 20px 18px 5px;
        }

        .breadcrumb {
            margin: 0 0 6px;
            color: var(--blue);
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 0.1px;
            text-transform: uppercase;
        }

        h1 {
            margin: 0;
            color: #1d3857;
            font-size: 21px;
            font-weight: 700;
            letter-spacing: -0.5px;
            line-height: 1.25;
        }

        .page-subtitle {
            margin: 5px 0 15px;
            color: #91a0b2;
            font-size: 11px;
        }

        .edit-layout {
            display: grid;
            grid-template-columns: minmax(180px, 199px) minmax(0, 1fr);
            align-items: start;
            gap: 16px;
        }

        .photo-column,
        .listing-fields {
            min-width: 0;
        }

        .field-label {
            display: block;
            margin-bottom: 6px;
            color: #405b77;
            font-size: 10px;
            font-weight: 700;
        }

        .photo-preview {
            height: 130px;
            display: grid;
            place-items: center;
            overflow: hidden;
            border-radius: 9px;
            background: #e7edf5;
            color: #8292a6;
            font-size: 9px;
        }

        .photo-controls {
            display: flex;
            gap: 7px;
            margin-top: 8px;
        }

        .photo-thumb,
        .photo-add {
            width: 55px;
            height: 42px;
            display: grid;
            flex: 0 0 55px;
            place-items: center;
            border: 1px solid transparent;
            border-radius: 9px;
            background: #e7edf5;
            color: #8092a7;
            font-size: 10px;
        }

        .photo-thumb {
            cursor: pointer;
        }

        .photo-add {
            position: relative;
            border-color: #e2eaf4;
            background: #fff;
            color: #7f92a8;
            font-size: 20px;
            font-weight: 300;
            cursor: pointer;
        }

        .photo-add input {
            position: absolute;
            width: 1px;
            height: 1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            clip-path: inset(50%);
        }

        .photo-add:focus-within {
            border-color: #8bb5f0;
            box-shadow: 0 0 0 3px rgba(29, 107, 225, 0.1);
        }

        .photo-hint {
            margin: 9px 0 9px;
            color: #94a2b3;
            font-size: 9px;
        }

        .form-control {
            width: 100%;
            height: 36px;
            padding: 0 11px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: #fff;
            color: #546b84;
            font-size: 11px;
        }

        select.form-control {
            padding-right: 28px;
        }

        .field-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 11px 17px;
        }

        .form-field {
            min-width: 0;
        }

        .description-field {
            grid-column: 1 / -1;
        }

        textarea.form-control {
            min-height: 66px;
            height: 66px;
            padding-top: 10px;
            resize: vertical;
            line-height: 1.5;
        }

        .form-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-top: 17px;
        }

        .action-group {
            display: flex;
            gap: 8px;
        }

        .action-button {
            min-width: 75px;
            height: 35px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 14px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: #fff;
            color: #536b84;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
        }

        .action-button:hover {
            background: #f6f9fc;
        }

        .action-button.delete {
            min-width: 110px;
            border-color: #fde1df;
            background: #fde8e7;
            color: #d85b53;
        }

        .action-button.save {
            min-width: 61px;
            border-color: var(--blue);
            background: var(--blue);
            color: #fff;
        }

        .action-button.save:hover {
            background: #155fcf;
        }

        @media (max-width: 760px) {
            .app-frame {
                flex-direction: column;
                overflow: visible;
            }

            .sidebar {
                width: auto;
                flex: none;
                padding: 15px 15px 12px;
                border-radius: 11px 11px 0 0;
            }

            .brand {
                padding: 0 4px;
                font-size: 22px;
            }

            .sidebar-nav {
                display: flex;
                flex-wrap: wrap;
                gap: 5px;
                margin-top: 14px;
            }

            .sidebar-nav a {
                min-height: 34px;
                padding: 0 10px;
                font-size: 11px;
            }

            .sidebar-profile {
                display: none;
            }

            .main-content {
                padding: 12px;
            }

            .page-content {
                padding: 20px 3px 8px;
            }
        }

        @media (max-width: 520px) {
            .edit-layout {
                grid-template-columns: minmax(0, 1fr);
            }

            .photo-column {
                max-width: 260px;
            }

            .field-grid {
                grid-template-columns: minmax(0, 1fr);
                gap: 12px;
            }

            .description-field {
                grid-column: auto;
            }

            .form-actions {
                align-items: stretch;
                flex-direction: column-reverse;
            }

            .action-group {
                justify-content: flex-end;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
</head>

<body>
    <div class="app-frame">
        <aside class="sidebar">
            <a class="brand" href="{{ url('/') }}" aria-label="Circlo home">CIRCLO</a>

            <nav class="sidebar-nav" aria-label="Main navigation">
                <a href="{{ url('/') }}">Home</a>
                <a href="{{ url('/explore') }}">Explore</a>
                <a href="{{ url('/transactions') }}">My Transactions</a>
                <a href="{{ url('/items') }}" aria-current="page">My Items</a>
            </nav>

            <div class="sidebar-profile">
                <div class="profile-name"><span class="profile-dot" aria-hidden="true"></span>Alya Putri</div>
                <div class="profile-school">ITS Student</div>
            </div>
        </aside>

        <main class="main-content">
            <div class="search-bar">
                <input class="search-input" type="search" aria-label="Search Circlo"
                    placeholder="Search for items, categories, or owners...">
            </div>

            <section class="page-content" aria-labelledby="page-title">
                <p class="breadcrumb">Circlo / Student</p>
                <h1 id="page-title">Edit Item</h1>
                <p class="page-subtitle">Update your listing information.</p>

                <form>
                    <div class="edit-layout">
                        <section class="photo-column" aria-labelledby="photo-label">
                            <span class="field-label" id="photo-label">Item Photos</span>
                            <div class="photo-preview" role="img" aria-label="Item photo preview">ITEM PHOTO</div>
                            <div class="photo-controls" aria-label="Listing photos">
                                <button class="photo-thumb" type="button" aria-label="Photo 1">1</button>
                                <button class="photo-thumb" type="button" aria-label="Photo 2">2</button>
                                <label class="photo-add" aria-label="Add photos">
                                    <span aria-hidden="true">+</span>
                                    <input type="file" accept="image/png,image/jpeg" multiple>
                                </label>
                            </div>
                            <p class="photo-hint">Up to 5 photos · PNG or JPG</p>

                            <label class="field-label" for="availability">Availability</label>
                            <select class="form-control" id="availability" name="availability">
                                <option selected>Available</option>
                                <option>Unavailable</option>
                            </select>
                        </section>

                        <div class="listing-fields">
                            <div class="field-grid">
                                <div class="form-field">
                                    <label class="field-label" for="item-name">Item Name</label>
                                    <input class="form-control" id="item-name" name="name" value="Macbook Air M1">
                                </div>
                                <div class="form-field">
                                    <label class="field-label" for="category">Category</label>
                                    <select class="form-control" id="category" name="category">
                                        <option selected>Electronics</option>
                                        <option>Books</option>
                                        <option>Home &amp; Living</option>
                                        <option>Sports</option>
                                    </select>
                                </div>
                                <div class="form-field">
                                    <label class="field-label" for="condition">Condition</label>
                                    <select class="form-control" id="condition" name="condition">
                                        <option selected>Good</option>
                                        <option>Like new</option>
                                        <option>Fair</option>
                                    </select>
                                </div>
                                <div class="form-field">
                                    <label class="field-label" for="listing-type">Listing Type</label>
                                    <select class="form-control" id="listing-type" name="listing_type">
                                        <option selected>Renting</option>
                                        <option>Borrowing</option>
                                        <option>Selling</option>
                                    </select>
                                </div>
                                <div class="form-field">
                                    <label class="field-label" for="price">Price per Day</label>
                                    <input class="form-control" id="price" name="price" value="Rp 50.000">
                                </div>
                                <div class="form-field">
                                    <label class="field-label" for="pickup-location">Pickup Location</label>
                                    <input class="form-control" id="pickup-location" name="pickup_location" value="ITS Library">
                                </div>
                                <div class="form-field description-field">
                                    <label class="field-label" for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description">Macbook Air M1 8GB RAM 256GB SSD. Good condition, ready for daily use.</textarea>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button class="action-button delete" type="button">Delete Listing</button>
                                <div class="action-group">
                                    <button class="action-button" type="button">Cancel</button>
                                    <button class="action-button save" type="button">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
        </main>
    </div>
</body>

</html>
