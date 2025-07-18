<?php
// Текущие день, месяц и год
$today = getdate();
$current_year = $today['year'];
$current_month = $today['mon'];
$current_day = $today['mday'];

// Аргументы для WP_Query
$args = array(
    'posts_per_page' => -1, // Показываем все подходящие статьи
    'date_query' => array(
        array(
            'column' => 'post_date', // Используем столбец post_date для точной проверки
            'before' => "$current_year-$current_month-$current_day",
            'inclusive' => false,     // Исключаем сам текущий день текущего года
            'month' => $current_month,
            'day' => $current_day,
        ),
    ),
	'category_name' => 'novosti-sdk', // Ограничиваем выборкой по указанной категории
    'order' => 'DESC',               // Сортируем по убывающей дате (новые статьи вверху)
    'orderby' => 'date'              // Сортировка по дате публикации
);

// Создаем объект WP_Query
$query = new WP_Query($args);

// Проверяем наличие результатов
if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();
// Дата публикации только годом 
echo '<span class="post-year">' . get_the_date('Y') . ' год</span>';
        ?>

        <div class="post-content">
			
            <a href="<?php the_permalink(); ?>" class="post-title-link">
                <?php if(has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('large'); ?>
                <?php endif; ?>
                <h4 class="post-title"><?php the_title(); ?></h4>
                <p class="post-excerpt"><?php the_excerpt(); ?></p>
				<p class="post-date">Дата публикации: <?php the_date('F j, Y'); ?></p>
            </a>
            
        </div>
        <?php
    }
} else {
    echo 'Событий и статей за прошлые годы нет';
}

// Восстанавливаем глобальную переменную $post
wp_reset_postdata();