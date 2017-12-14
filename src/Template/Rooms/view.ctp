<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $room
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Room'), ['action' => 'edit', $room->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Room'), ['action' => 'delete', $room->id], ['confirm' => __('Are you sure you want to delete # {0}?', $room->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Rooms'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Room'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="rooms view large-9 medium-8 columns content">
    <h3><?= h($room->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($room->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($room->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Capacity') ?></th>
            <td><?= $this->Number->format($room->capacity) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($room->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($room->modified) ?></td>
        </tr>
    </table>
    <table style="word-wrap: break-word;">
        <tr>
        <th scope="row"><?= __('Lundi') ?></th>
            
        <th scope="row"><?= __('Mardi') ?></th>
            
        <th scope="row"><?= __('Mercredi') ?></th>
            
        <th scope="row"><?= __('Jeudi') ?></th>
            
        <th scope="row"><?= __('Vendredi') ?></th>
            
        <th scope="row"><?= __('Samedi') ?></th>
            
        <th scope="row"><?= __('Dimanche') ?></th>
        </tr>
        <?php for($i=1;$i<=7;$i++): ?>
        <td>
            <?php foreach($showtimesThisWeek[$i] as $show):?>
                <p><?= $show ?></p>
            <?php endforeach; ?>
        </td>
        <?php endfor; ?>
    </table>
</div>
