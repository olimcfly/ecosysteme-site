import CityChecker from './CityChecker'

export default function CTASection() {
  return (
    <section id="cta-final" className="section-pad bg-navy-700">
      <div className="container-main">
        <div className="max-w-xl mx-auto text-center mb-10">
          <h2 className="text-3xl sm:text-4xl font-bold text-white mb-4">
            Votre ville est peut-être encore libre.
          </h2>
          <p className="text-navy-200 text-lg leading-relaxed">
            La vérification est gratuite et sans engagement. Réponse d&apos;Olivier sous 24h ouvrées.
            Une fois votre ville prise par un concurrent, il n&apos;y a pas de retour en arrière.
          </p>
        </div>

        <div className="max-w-xl mx-auto">
          <CityChecker />
        </div>

        <p className="text-center text-navy-400 text-sm mt-8">
          Ou appelez Olivier directement —{' '}
          <a
            href="tel:+33785611700"
            className="text-navy-300 hover:text-white transition-colors font-medium"
          >
            07 85 61 17 00
          </a>
          {' '}·{' '}
          <a
            href="mailto:contact@ecosystemeimmo.fr"
            className="text-navy-300 hover:text-white transition-colors"
          >
            contact@ecosystemeimmo.fr
          </a>
        </p>
      </div>
    </section>
  )
}
