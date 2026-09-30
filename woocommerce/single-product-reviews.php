<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.7.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! comments_open() ) {
	return;
}

$count = $product ? $product->get_review_count() : 0;
$average_rating = $product ? (float) $product->get_average_rating() : 0;
?>
<div id="reviews" class="woocommerce-Reviews w-full">
    <!-- Editorial Section Header -->
    <div class="mb-space-lg">
        <span class="font-label-caps text-label-caps uppercase tracking-[0.2em] text-secondary">Opiniones Reales</span>
        <h2 class="font-headline-md text-headline-md tracking-tight text-on-surface font-normal mt-1">Valoraciones de la Comunidad</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter-desktop items-start">
        <!-- Left Column: Reviews List & Summary -->
        <div id="comments" class="lg:col-span-5 space-y-space-md">
            <?php if ( have_comments() ) : ?>
                <div class="bg-surface-container-low p-space-md shadow-sm space-y-space-xs">
                    <div class="flex items-baseline gap-2">
                        <span class="font-headline-lg text-headline-lg font-medium text-on-surface"><?php echo esc_html( number_format_i18n( $average_rating, 1 ) ); ?></span>
                        <span class="font-body-sm text-body-sm text-secondary">/ 5.0</span>
                    </div>
                    <?php if ( wc_review_ratings_enabled() ) : ?>
                        <div class="star-rating" role="img" aria-label="<?php echo sprintf( esc_attr__( 'Calificado con %s de 5', 'woocommerce' ), $average_rating ); ?>">
                            <span style="width:<?php echo ( ( $average_rating / 5 ) * 100 ); ?>%"></span>
                        </div>
                    <?php endif; ?>
                    <p class="font-label-caps text-label-caps uppercase tracking-wider text-secondary">
                        <?php echo sprintf( esc_html( _n( 'Basado en %s valoración', 'Basado en %s valoraciones', $count, 'woocommerce' ) ), esc_html( $count ) ); ?>
                    </p>
                </div>

                <ol class="commentlist space-y-space-md list-none p-0 m-0 divide-y divide-surface-container">
                    <?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
                </ol>

                <?php
                if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
                    echo '<nav class="woocommerce-pagination pt-space-sm">';
                    paginate_comments_links(
                        apply_filters(
                            'woocommerce_comment_pagination_args',
                            array(
                                'prev_text' => '&larr;',
                                'next_text' => '&rarr;',
                                'type'      => 'list',
                            )
                        )
                    );
                    echo '</nav>';
                endif;
                ?>
            <?php else : ?>
                <div class="bg-surface-container-low p-space-lg space-y-space-xs shadow-sm">
                    <div class="flex items-center gap-1 text-on-surface text-lg">
                        <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                    </div>
                    <h3 class="font-headline-sm text-headline-sm text-on-surface font-medium mt-2">Aún no hay valoraciones</h3>
                    <p class="font-body-md text-body-md text-secondary">
                        Sé el primero en compartir tu experiencia sobre el confort, el ajuste y la suavidad de este diseño.
                    </p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Right Column: Review Form -->
        <div id="review_form_wrapper" class="lg:col-span-7 bg-surface-container-lowest p-space-md md:p-space-lg shadow-sm border border-surface-container">
            <?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>
                <div id="review_form">
                    <?php
                    $commenter    = wp_get_current_commenter();
                    $comment_form = array(
                        'title_reply'         => have_comments() ? esc_html__( 'Dejá tu reseña', 'woocommerce' ) : sprintf( esc_html__( 'Sé el primero en valorar “%s”', 'woocommerce' ), get_the_title() ),
                        'title_reply_to'      => esc_html__( 'Responder a %s', 'woocommerce' ),
                        'title_reply_before'  => '<h3 id="reply-title" class="comment-reply-title font-headline-sm text-headline-sm text-on-surface font-medium block mb-1">',
                        'title_reply_after'   => '</h3>',
                        'comment_notes_before'=> '<p class="comment-notes font-body-sm text-body-sm text-secondary mb-space-md">' . esc_html__( 'Tu dirección de correo no será publicada. Los campos obligatorios están marcados con *', 'woocommerce' ) . '</p>',
                        'comment_notes_after' => '',
                        'class_form'          => 'comment-form space-y-space-md',
                        'class_submit'        => 'submit h-12 px-8 bg-primary text-on-primary font-label-caps text-label-caps uppercase tracking-widest hover:bg-secondary transition-colors cursor-pointer border-none flex items-center justify-center',
                        'label_submit'        => esc_html__( 'Publicar Valoración', 'woocommerce' ),
                        'logged_in_as'        => '',
                        'comment_field'       => '',
                    );

                    $name_email_required = (bool) get_option( 'require_name_email', 1 );
                    $fields              = array(
                        'author' => array(
                            'label'        => __( 'Nombre', 'woocommerce' ),
                            'type'         => 'text',
                            'value'        => $commenter['comment_author'],
                            'required'     => $name_email_required,
                            'autocomplete' => 'name',
                            'placeholder'  => __( 'Tu nombre', 'woocommerce' ),
                        ),
                        'email'  => array(
                            'label'        => __( 'Correo electrónico', 'woocommerce' ),
                            'type'         => 'email',
                            'value'        => $commenter['comment_author_email'],
                            'required'     => $name_email_required,
                            'autocomplete' => 'email',
                            'placeholder'  => 'ejemplo@correo.com',
                        ),
                    );

                    $comment_form['fields'] = array();

                    foreach ( $fields as $key => $field ) {
                        $field_html  = '<div class="comment-form-' . esc_attr( $key ) . ' space-y-1">';
                        $field_html .= '<label for="' . esc_attr( $key ) . '" class="block font-label-caps text-label-caps uppercase tracking-wider text-secondary font-semibold">' . esc_html( $field['label'] );

                        if ( $field['required'] ) {
                            $field_html .= '&nbsp;<span class="required text-on-surface">*</span>';
                        }

                        $field_html .= '</label><input id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" type="' . esc_attr( $field['type'] ) . '" autocomplete="' . esc_attr( $field['autocomplete'] ) . '" value="' . esc_attr( $field['value'] ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '" class="w-full h-12 bg-surface-container-low px-4 font-body-md text-on-surface focus:outline-none focus:bg-surface-container-high transition-colors border-none" ' . ( $field['required'] ? 'required' : '' ) . ' /></div>';

                        $comment_form['fields'][ $key ] = $field_html;
                    }

                    $account_page_url = wc_get_page_permalink( 'myaccount' );
                    if ( $account_page_url ) {
                        $comment_form['must_log_in'] = '<p class="must-log-in font-body-sm text-body-sm text-secondary">' . sprintf( esc_html__( 'Debes %1$siniciar sesión%2$s para publicar una valoración.', 'woocommerce' ), '<a href="' . esc_url( $account_page_url ) . '" class="underline text-on-surface">', '</a>' ) . '</p>';
                    }

                    if ( wc_review_ratings_enabled() ) {
                        $comment_form['comment_field'] = '<div class="comment-form-rating space-y-1.5"><label for="rating" id="comment-form-rating-label" class="block font-label-caps text-label-caps uppercase tracking-wider text-secondary font-semibold">' . esc_html__( 'Tu puntuación', 'woocommerce' ) . ( wc_review_ratings_required() ? '&nbsp;<span class="required text-on-surface">*</span>' : '' ) . '</label><select name="rating" id="rating" required style="display:none;">
                            <option value="">' . esc_html__( 'Puntuar…', 'woocommerce' ) . '</option>
                            <option value="5">' . esc_html__( 'Perfecto', 'woocommerce' ) . '</option>
                            <option value="4">' . esc_html__( 'Bueno', 'woocommerce' ) . '</option>
                            <option value="3">' . esc_html__( 'Normal', 'woocommerce' ) . '</option>
                            <option value="2">' . esc_html__( 'No está tan mal', 'woocommerce' ) . '</option>
                            <option value="1">' . esc_html__( 'Muy pobre', 'woocommerce' ) . '</option>
                        </select></div>';
                    }

                    $comment_form['comment_field'] .= '<div class="comment-form-comment space-y-1"><label for="comment" class="block font-label-caps text-label-caps uppercase tracking-wider text-secondary font-semibold">' . esc_html__( 'Tu valoración', 'woocommerce' ) . '&nbsp;<span class="required text-on-surface">*</span></label><textarea id="comment" name="comment" cols="45" rows="4" placeholder="' . esc_attr__( 'Contanos qué te pareció el diseño, la suavidad del tejido y el ajuste al usarlo...', 'woocommerce' ) . '" class="w-full bg-surface-container-low p-4 font-body-md text-on-surface focus:outline-none focus:bg-surface-container-high transition-colors border-none min-h-[110px] resize-y" required></textarea></div>';

                    comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
                    ?>
                </div>
            <?php else : ?>
                <div class="p-space-md bg-surface-container-low text-secondary font-body-sm shadow-sm">
                    <p class="woocommerce-verification-required"><?php esc_html_e( 'Solo los clientes registrados que hayan adquirido este producto pueden dejar una valoración.', 'woocommerce' ); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
