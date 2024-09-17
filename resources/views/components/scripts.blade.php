<script type="text/javascript">
   window.addEventListener('scroll', function() {
      const header = document.getElementById('header');
      const banner = document.getElementById('banner');
      const logo = document.getElementById('logo');

      const currentPath = window.location.pathname;

      if (currentPath !== '/my') { // Show header and logo on all pages except '/my'
         if (window.scrollY > 30) {
            header.classList.remove('w-[95%]', 'ml-[2.5%]', 'rounded-xl', 'px-8', 'mt-3');
            header.classList.add('w-full', 'px-6', 'ml-0');
            logo.classList.remove('w-16');
            logo.classList.add('w-[64px]');

            if (currentPath.match(/^\/services\/\d+$/)) {
               banner.classList.remove('mt-[100px]', 'w-[90%]');
               banner.classList.add('mt-[90px]', 'w-[93%]');
            }
         } else {
            header.classList.remove('w-full', 'ml-0', 'px-6');
            header.classList.add('w-[95%]', 'ml-[2.5%]', 'rounded-xl', 'mt-3', 'px-8');
            logo.classList.remove('w-[64px]');
            logo.classList.add('w-16');

            if (currentPath.match(/^\/services\/\d+$/)) {
               banner.classList.remove('mt-[90px]', 'w-[93%]');
               banner.classList.add('mt-[100px]', 'w-[90%]');
            }
         }
      }
   });

   const navLinks = document.getElementById('nav-links');
   const menuIcon = document.getElementById('menu-icon');
   const body = document.body;

   function toggleMenu() {
      // Toggle the 'hidden' class to show/hide the nav-links
      navLinks.classList.toggle('hidden');
      navLinks.classList.toggle('flex');

      // Toggle the icon between 'menu-outline' and 'close-outline'
      const currentName = menuIcon.getAttribute('name');
      menuIcon.setAttribute('name', currentName === 'menu' ? 'close' : 'menu');

      // Toggle body overflow
      body.classList.toggle('overflow-hidden');
   }

   function showDialog(dialogId) {
      const dialog = document.getElementById(dialogId);
      const bg = document.getElementById('dialog-bg-' + dialogId.split('-')[1]);

      dialog.classList.remove('hidden');
      bg.classList.remove('hidden');

      setTimeout(() => {
         dialog.classList.add('opacity-100');
         bg.classList.add('opacity-90');
      }, 70);
   }

   function hideDialog(dialogId) {
      const dialog = document.getElementById(dialogId);
      const bg = document.getElementById('dialog-bg-' + dialogId.split('-')[1]);

      dialog.classList.remove('opacity-100');
      bg.classList.remove('opacity-90');

      setTimeout(() => {
         dialog.classList.add('hidden');
         bg.classList.add('hidden');
      }, 50);
   }
</script>

<script>
   tinymce.init({
      selector: 'textarea',
      plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | spellcheckdialog typography | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
      mergetags_list: [{
            value: 'First.Name',
            title: 'First Name'
         },
         {
            value: 'Email',
            title: 'Email'
         },
      ],
   });
</script>
