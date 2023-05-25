<template>
  <nav>
    <ul class="flex space-x-6">
      <li>
        <NavLink href="/" :active="$page.component === 'Home'">
          Ana Sayfa
        </NavLink>
      </li>

      <li>
        <NavLink href="/users" :active="$page.component === 'Users'">
          kullanıcılar
        </NavLink>
      </li>

      <li>
        <NavLink href="/blogs" :active="$page.component === 'Blogs'">
          Blog Yazılar
        </NavLink>
      </li>

      <li>
        <NavLink href="/settings" :active="$page.component === 'Settings'">
          Ayarlar
        </NavLink>
      </li>

      <li>
        <NavLink href="/logout" method="post" as="button">
          Çıkış Yap
        </NavLink>
      </li>
    </ul>
  </nav>
</template>

<script>
import NavLink from "./NavLink";

export default {
  components: { NavLink },
};
</script>
