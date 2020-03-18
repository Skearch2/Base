<h1>Manage Groups</h1>

<ul>
    <li><?php echo anchor('acl/admin/manage', 'Back to admin'); ?></li>
</ul>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($groups as $group) : ?>
            <tr>
                <td><?php echo $group->id; ?></td>
                <td><?php echo $group->description; ?></td>
                <td>
                    <a href="/skearch/acl/admin/group-permissions/<?php echo $group->id; ?>">Manage Permissions</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>