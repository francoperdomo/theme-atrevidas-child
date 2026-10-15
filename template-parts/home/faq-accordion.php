<?php
/**
 * Home: FAQ Accordion (Atrevidas)
 * Preguntas frecuentes con HTML5 nativo (<details>) para derribar dudas sobre discreción, pagos y envíos.
 *
 * @package SimpleWoo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$faqs = array(
	array(
		'q' => '¿Cómo vienen embalados los paquetes? ¿Se nota qué hay adentro?',
		'a' => 'La discreción es nuestra máxima prioridad. Todos los pedidos se despachan en cajas o sobres lisos, totalmente sellados y sin ningún tipo de logo, inscripción ni mención de Sexshop o Atrevidas. El remitente es una persona o razón social genérica, de modo que nadie sabrá el contenido del paquete.',
	),
	array(
		'q' => '¿Qué nombre aparece en el resumen de mi tarjeta o banco?',
		'a' => 'Tu privacidad financiera está protegida. En el resumen de tu tarjeta de crédito, débito o cuenta bancaria aparecerá únicamente una razón social neutra o el procesador de pagos utilizado (por ejemplo, Mercado Pago o Gateway de Pagos), sin ninguna referencia al rubro de productos íntimos.',
	),
	array(
		'q' => '¿Cómo sé cuál es mi talle de lencería y cuál es la política de cambios?',
		'a' => 'En la ficha de cada conjunto encontrás una guía de medidas detallada. Por estrictas normas de higiene y salud pública, las prendas de lencería y bombachas no admiten cambio una vez abiertas. En caso de juguetes o accesorios electrónicos, cuentan con garantía directa ante fallas de fábrica dentro del período establecido.',
	),
	array(
		'q' => '¿Cuáles son los tiempos de entrega y métodos de envío?',
		'a' => 'Realizamos envíos a todo el país mediante correo privado o encomienda con seguimiento online. Además, podés elegir retirar en sucursal del correo para mayor reserva si preferís no recibirlo en tu domicilio. Los despachos se procesan en 24 a 48 hs hábiles desde la confirmación de la compra.',
	),
);
?>

<section class="gs-faq w-full px-4 sm:px-6 lg:px-8 py-12 md:py-16 bg-surface" aria-label="Preguntas frecuentes">
	<div class="max-w-3xl mx-auto">

		<div class="text-center mb-8">
			<span class="font-label-caps text-label-caps text-secondary uppercase tracking-widest block mb-1">
				Dudas Frecuentes
			</span>
			<h2 class="font-headline-md text-headline-md text-on-surface">
				Todo lo que necesitás saber
			</h2>
			<p class="font-body-sm text-secondary mt-2">
				Comprá con absoluta tranquilidad y confianza.
			</p>
		</div>

		<div class="space-y-3">
			<?php foreach ( $faqs as $faq ) : ?>
				<details class="group bg-surface-container-lowest border border-surface-container-highest rounded-xl p-4 md:p-5 transition-colors duration-200">
					<summary class="flex items-center justify-between cursor-pointer list-none font-body-md font-bold text-on-surface select-none focus:outline-none">
						<span><?php echo esc_html( $faq['q'] ); ?></span>
						<span class="ml-4 flex-shrink-0 text-secondary group-open:rotate-45 transition-transform duration-200 text-xl font-light">
							+
						</span>
					</summary>
					<p class="mt-3 font-body-sm text-secondary leading-relaxed pt-3 border-t border-surface-container m-0">
						<?php echo esc_html( $faq['a'] ); ?>
					</p>
				</details>
			<?php endforeach; ?>
		</div>

	</div>
</section>
