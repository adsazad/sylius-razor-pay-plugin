<?php

declare(strict_types=1);

namespace Srkits\SyliusRazorPayPlugin\Payum\Action;

use Srkits\SyliusRazorPayPlugin\Payum\SyliusApi;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Payum\Core\Action\ActionInterface;
use Payum\Core\ApiAwareInterface;
use Payum\Core\Security\TokenInterface;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Exception\UnsupportedApiException;
use Sylius\Component\Core\Model\PaymentInterface as SyliusPaymentInterface;
use Payum\Core\Request\Capture;

final class CaptureAction implements ActionInterface, ApiAwareInterface
{
    /** @var Client */
    private $client;
    /** @var SyliusApi */
    private $api;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function execute($request): void
    {
        RequestNotSupportedException::assertSupports($this, $request);

        /** @var SyliusPaymentInterface $payment */
        $payment = $request->getModel();

       /* try {
            $response = $this->client->request('POST', 'https://sylius-payment.free.beeceptor.com', [
                'body' => json_encode([
                    'price' => $payment->getAmount(),
                    'currency' => $payment->getCurrencyCode(),
                    'api_key' => $this->api->getApiKey(),
                    'api_secret' => $this->api->getApiSecret(),
                ]),
            ]);
        } catch (RequestException $exception) {
            $response = $exception->getResponse();
        } finally {
            $payment->setDetails(['status' => $response->getStatusCode()]);
        }*/
        $token = $request->getToken();
        $action = $token->getTargetUrl();
        $options['key'] = $this->api->getApiKey();
        $options['amount'] = $payment->getAmount();
        $options['currency'] = 'INR';
        $options = json_encode($options);
        $form = <<<HTML
<form id="form" action="$action" method="POST">
<input type="hidden" id="razorpay_payment_id" name="razorpay_payment_id" value="">
</form>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
	var options = $options;
	
	options.handler = function(response) {
		document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
		document.getElementById('form').submit();
	}
	
	options.modal = {
		ondismiss: function() {
			document.getElementById('razorpay_payment_id').value = 'null';	
			document.getElementById('form').submit();
		}
	}
	
	var rzp = new Razorpay(options);
	rzp.open();
</script>
HTML;
		throw new HttpResponse($form);
    }

    public function supports($request): bool
    {
        return
            $request instanceof Capture &&
            $request->getModel() instanceof SyliusPaymentInterface
        ;
    }

    public function setApi($api): void
    {
        if (!$api instanceof SyliusApi) {
            throw new UnsupportedApiException('Not supported. Expected an instance of ' . SyliusApi::class);
        }

        $this->api = $api;
    }
}