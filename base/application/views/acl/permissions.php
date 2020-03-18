<h1>Manage Permissions</h1>

<ul>
    <li><?php echo anchor('/acl/admin/add-permission', 'Add Permission'); ?></li>
    <li><?php echo anchor('/acl/admin/manage', 'Back to admin'); ?></li>
</ul>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Key</th>
            <th>Description</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($permissions as $permission) : ?>
            <tr>
                <td><?php echo $permission['id']; ?></td>
                <td><?php echo $permission['key']; ?></td>
                <td><?php echo $permission['name']; ?></td>
                <td>
                    <a href="/skearch/acl/admin/update-permission/<?php echo $permission['id']; ?>">Edit</a>
                    <a href="/skearch/acl/admin/delete-permission/<?php echo $permission['id']; ?>">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>