<?php

namespace src\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;

class kernel_exception_subscriber implements EventSubscriberInterface
{
	/**
	* Template object
	* @var \src\template\template
	*/
	protected $template;

	/**
	* User object
	* @var \src\user
	*/
	protected $user;

	/**
	* Construct method
	*
	* @param \src\template\template $template Template object
	* @param \src\user $user User object
	*/
	public function __construct(\src\template\template $template, \src\user $user)
	{
		$this->template = $template;
		$this->user = $user;
	}

	/**
	* This listener is run when the KernelEvents::EXCEPTION event is triggered
	*
	* @param GetResponseForExceptionEvent $event
	* @return null
	*/
	public function on_kernel_exception(GetResponseForExceptionEvent $event)
	{
		$exception = $event->getException();

		$message = $exception->getMessage();

		if ($exception instanceof \src\exception\exception_interface)
		{
			$message = call_user_func_array(array($this->user, 'lang'), array_merge(array($message), $exception->get_parameters()));
		}

		if (!$event->getRequest()->isXmlHttpRequest())
		{
			page_header($this->user->lang('INFORMATION'));

			$this->template->assign_vars(array(
				'MESSAGE_TITLE' => $this->user->lang('INFORMATION'),
				'MESSAGE_TEXT'  => $message,
			));

			$this->template->set_filenames(array(
				'body' => 'message_body.html',
			));

			page_footer(true, false, false);

			$response = new Response($this->template->assign_display('body'), 500);
		}
		else
		{
			$data = array();

			if (!empty($message))
			{
				$data['message'] = $message;
			}

			if (defined('DEBUG'))
			{
				$data['trace'] = $exception->getTrace();
			}

			$response = new JsonResponse($data, 500);
		}

		if ($exception instanceof HttpExceptionInterface)
		{
			$response->setStatusCode($exception->getStatusCode());
			$response->headers->add($exception->getHeaders());
		}

		$event->setResponse($response);
	}

	public static function getSubscribedEvents()
	{
		return array(
			KernelEvents::EXCEPTION		=> 'on_kernel_exception',
		);
	}
}
