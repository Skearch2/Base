<h1>Manage Users</h1>

<ul>
    <li><?php echo anchor('/acl/admin/manage', 'Back to admin'); ?></li>
</ul>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user) : ?>
            <tr>
                <td><?php echo $user->id; ?></td>
                <td><?php echo $user->username; ?></td>
                <td>
                    <a href="/skearch/acl/admin/manage-user/<?php echo $user->id; ?>">Manage User</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>