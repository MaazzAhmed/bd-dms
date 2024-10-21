<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<header>

	<div class="topbar d-flex align-items-center">

		<nav class="navbar navbar-expand">

			<div class="mobile-toggle-menu"><i class='bx bx-menu'></i>

			</div>



			<div class="top-menu ms-auto">

				<ul class="navbar-nav align-items-center">

					<li class="nav-item mobile-search-icon">

						<a class="nav-link" href="#"> <i class='bx bx-search'></i>

						</a>

					</li>



				</ul>

			</div>

			<!-- <script src="main_components/menu.js"></script> -->

			<script>
				// Get all elements with class 'dropdownToggle'
				var dropdownToggleElements = document.getElementsByClassName('dropdownToggle');

				// Iterate over each 'dropdownToggle' element and add event listener
				for (var i = 0; i < dropdownToggleElements.length; i++) {
					dropdownToggleElements[i].addEventListener('click', function() {
						// Add the 'show' class to the dropdown toggle button
						this.classList.add('show');

						// Add the 'show' class to the dropdown menu
						var dropdownMenu = this.nextElementSibling;
						dropdownMenu.classList.add('show');
					});
				}
			</script>


			<div class="user-box dropdown">

				<a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">

					<!-- <img src="assets/images/avatars/avatar-2.png" class="user-img" alt="user avatar"> -->

					<div class="user-info ps-3">

						<p class="user-name mb-0"><?php echo $_SESSION['user'] ?></p>

						<p class="designattion mb-0"><?php echo $_SESSION['email'] ?></p>

					</div>

				</a>

				<ul class="dropdown-menu dropdown-menuS dropdown-menu-end ">



					<div class="dropdown-divider mb-0"></div>
					<p style="margin-left: 20px;" class='bx bx-user-circle'><?php echo $_SESSION['role'] ?></p>
					</li>

					<li>
    <form action="logout" method="post">
        <input type="hidden" name="access_token" value="mdalmladmfdmald22">
        <button type="submit" name="loggg" class="dropdown-item">
            <i class='bx bx-log-out-circle'></i><span>Logout</span>
        </button>
    </form>
</li>

					</li>

				</ul>

			</div>

		</nav>

	</div>

</header>